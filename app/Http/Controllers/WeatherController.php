<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    private string $apiKey;
    private string $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function __construct()
    {
        $this->apiKey = config('services.owm.key', env('OWM_API_KEY', ''));
    }

    public function index()
    {
        return view('pages.cuaca');
    }

    public function fetch(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:100',
        ]);

        $data = $this->getWeather($request->city);

        if (isset($data['error'])) {
            return response()->json(['success' => false, 'message' => $data['error']], 422);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function fetchDash(Request $request)
    {
        return $this->fetch($request);
    }

    /**
     * Core method — strict Indonesia-only validation
     */
    public function getWeather(string $city): array
    {
        $cleaned = trim($city);

        if (strlen($cleaned) < 2) {
            return ['error' => 'Nama kota terlalu pendek. Masukkan nama kota yang valid.'];
        }

        // Tolak input tanpa vokal (kemungkinan besar typo/random)
        if (!preg_match('/[aeiouAEIOU]/', $cleaned)) {
            return ['error' => "'{$cleaned}' bukan nama kota yang valid. Coba nama seperti: Malang, Surabaya, Semarang."];
        }

        if (empty($this->apiKey) || $this->apiKey === 'YOUR_OWM_API_KEY_HERE') {
            return $this->getDemoWeather($city);
        }

        try {
            // Selalu cari dengan filter Indonesia (,ID)
            $response = Http::timeout(10)->get("{$this->baseUrl}/weather", [
                'q'     => $cleaned . ',ID',
                'appid' => $this->apiKey,
                'units' => 'metric',
                'lang'  => 'id',
            ]);

            // Tidak ditemukan di Indonesia → langsung error, tidak fallback global
            if ($response->status() === 404) {
                return ['error' => "Kota '{$cleaned}' tidak ditemukan di Indonesia. Coba nama kota lain seperti: Malang, Klaten, Purwokerto."];
            }

            if ($response->status() === 401) {
                return ['error' => 'API key tidak valid. Periksa konfigurasi OWM_API_KEY.'];
            }

            if ($response->failed()) {
                return ['error' => 'Gagal mengambil data cuaca. Coba lagi beberapa saat.'];
            }

            $raw = $response->json();

            // Double-check: pastikan hasil dari OWM memang negara Indonesia
            $country = $raw['sys']['country'] ?? '';
            if ($country !== 'ID') {
                return ['error' => "'{$cleaned}' tidak ditemukan sebagai kota di Indonesia. Pastikan nama kota benar."];
            }

            return $this->formatWeather($raw);

        } catch (\Exception $e) {
            Log::error('OWM API Error: ' . $e->getMessage());
            return ['error' => 'Koneksi gagal. Periksa koneksi internet Anda.'];
        }
    }

    private function formatWeather(array $raw): array
    {
        $condId  = $raw['weather'][0]['id'] ?? 800;
        $condKey = $this->getConditionKey($condId);

        return [
            'name' => $this->cleanCityName($raw['name']),
            'country'    => $raw['sys']['country'] ?? 'ID',
            'temp'       => round($raw['main']['temp']),
            'feels_like' => round($raw['main']['feels_like']),
            'humidity'   => $raw['main']['humidity'],
            'pressure'   => $raw['main']['pressure'],
            'wind_speed' => round($raw['wind']['speed'] * 3.6),
            'wind_deg'   => $raw['wind']['deg'] ?? 0,
            'visibility' => isset($raw['visibility']) ? round($raw['visibility'] / 1000) : null,
            'clouds'     => $raw['clouds']['all'] ?? 0,
            'description'=> $raw['weather'][0]['description'] ?? 'Tidak diketahui',
            'icon_id'    => $condId,
            'emoji'      => $this->getEmoji($condId),
            'cond_key'   => $condKey,
        ];
    }

    private function getDemoWeather(string $city): array
    {
        $cityDb = [
            'surabaya'  => ['temp' => 31, 'humidity' => 78, 'wind' => 15, 'pressure' => 1010, 'id' => 801],
            'solo'      => ['temp' => 28, 'humidity' => 74, 'wind' => 10, 'pressure' => 1012, 'id' => 800],
            'surakarta' => ['temp' => 28, 'humidity' => 74, 'wind' => 10, 'pressure' => 1012, 'id' => 800],
            'yogya'     => ['temp' => 27, 'humidity' => 76, 'wind' => 8,  'pressure' => 1011, 'id' => 801],
            'semarang'  => ['temp' => 30, 'humidity' => 80, 'wind' => 12, 'pressure' => 1009, 'id' => 500],
            'malang'    => ['temp' => 24, 'humidity' => 80, 'wind' => 9,  'pressure' => 1013, 'id' => 801],
            'default'   => ['temp' => 29, 'humidity' => 75, 'wind' => 10, 'pressure' => 1011, 'id' => 801],
        ];

        $key  = strtolower(trim($city));
        $data = $cityDb[$key] ?? $cityDb['default'];

        return [
            'name'        => ucwords($city),
            'country'     => 'ID',
            'temp'        => $data['temp'],
            'feels_like'  => $data['temp'] - 2,
            'humidity'    => $data['humidity'],
            'pressure'    => $data['pressure'],
            'wind_speed'  => $data['wind'],
            'wind_deg'    => 180,
            'visibility'  => 10,
            'clouds'      => 30,
            'description' => $this->getDescFromId($data['id']),
            'icon_id'     => $data['id'],
            'emoji'       => $this->getEmoji($data['id']),
            'cond_key'    => $this->getConditionKey($data['id']),
            'demo'        => true,
        ];
    }

    private function getConditionKey(int $id): string
    {
        if ($id >= 200 && $id < 300) return 'thunderstorm';
        if ($id >= 300 && $id < 400) return 'drizzle';
        if ($id >= 500 && $id < 600) return 'rain';
        if ($id >= 600 && $id < 700) return 'snow';
        if ($id >= 700 && $id < 800) return 'atmosphere';
        if ($id === 800)             return 'clear';
        return 'clouds';
    }

    private function getDescFromId(int $id): string
    {
        $map = [800=>'Cerah',801=>'Cerah Berawan',802=>'Berawan',
                803=>'Berawan',804=>'Mendung',500=>'Hujan Ringan',501=>'Hujan',
                200=>'Hujan Petir',300=>'Gerimis'];
        return $map[$id] ?? 'Cerah Berawan';
    }

    public function getEmoji(int $id): string
    {
        if ($id >= 200 && $id < 300) return '⛈️';
        if ($id >= 300 && $id < 400) return '🌦️';
        if ($id >= 500 && $id < 600) return '🌧️';
        if ($id >= 600 && $id < 700) return '❄️';
        if ($id >= 700 && $id < 800) return '🌫️';
        if ($id === 800)             return '☀️';
        if ($id === 801 || $id === 802) return '⛅';
        return '☁️';
    }

    private function cleanCityName(string $name): string
    {
        $name = preg_replace('/^(Kabupaten|Kota|Regency|City|Distrik|Daerah)\s+/i', '', $name);
        return trim($name);
    }
}