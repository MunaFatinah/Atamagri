<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RekomendasiController extends Controller
{
    private string $geminiKey;
    private string $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        $this->geminiKey = config('services.gemini.key', env('GEMINI_API_KEY', ''));
    }

    public function index()
    {
        return view('pages.rekomendasi');
    }

    /**
     * Public API endpoint
     */
    public function fetch(Request $request)
    {
        $request->validate([
            'city'     => 'required|string|max:100',
            'weather'  => 'nullable|array',
        ]);

        // Get weather first if not provided
        $weather = $request->weather;
        if (!$weather) {
            $wc      = app(WeatherController::class);
            $weather = $wc->getWeather($request->city);
            if (isset($weather['error'])) {
                return response()->json(['success' => false, 'message' => $weather['error']], 422);
            }
        }

        // Get AI recommendation from Gemini
        $rekomendasi = $this->getGeminiRekomendasi($weather, $request->city);

        return response()->json([
            'success'     => true,
            'weather'     => $weather,
            'rekomendasi' => $rekomendasi,
        ]);
    }

    /**
     * Dashboard AJAX endpoint
     */
    public function fetchDash(Request $request)
    {
        return $this->fetch($request);
    }

    /**
     * Get recommendations from Google Gemini API
     */
    private function getGeminiRekomendasi(array $weather, string $city): array
    {
        if (empty($this->geminiKey) || $this->geminiKey === 'YOUR_GEMINI_API_KEY_HERE') {
            return $this->getFallbackRekomendasi($weather);
        }

        $prompt = $this->buildPrompt($weather, $city);

        try {
            $response = Http::timeout(20)
                ->withQueryParameters(['key' => $this->geminiKey])
                ->post($this->geminiUrl, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature'     => 0.4,
                        'maxOutputTokens' => 2048,
                        'responseMimeType' => 'application/json',
                    ],
                ]);

            if ($response->failed()) {
                Log::warning('Gemini API failed: ' . $response->status() . ' - ' . $response->body());
                return $this->getFallbackRekomendasi($weather);
            }

            $body = $response->json();
            $text = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';
            $text = trim($text);

            // Strip markdown code fences if present
            $text = preg_replace('/^```json\s*/m', '', $text);
            $text = preg_replace('/```$/m', '', $text);
            $text = trim($text);

            $parsed = json_decode($text, true);

            if (!$parsed || !isset($parsed['tanaman'])) {
                Log::warning('Gemini response parse failed: ' . $text);
                return $this->getFallbackRekomendasi($weather);
            }

            return $parsed['tanaman'];

        } catch (\Exception $e) {
            Log::error('Gemini error: ' . $e->getMessage());
            return $this->getFallbackRekomendasi($weather);
        }
    }

    /**
     * Build Gemini prompt from weather data
     */
    private function buildPrompt(array $weather, string $city): string
    {
        $temp     = $weather['temp'] ?? 28;
        $hum      = $weather['humidity'] ?? 75;
        $wind     = $weather['wind_speed'] ?? 10;
        $pressure = $weather['pressure'] ?? 1010;
        $condKey  = $weather['cond_key'] ?? 'clouds';

        return <<<PROMPT
Kamu adalah ahli pertanian Indonesia. Berdasarkan data cuaca berikut, berikan rekomendasi 6 tanaman terbaik yang cocok ditanam sekarang.

Data cuaca saat ini di {$city}:
- Suhu: {$temp}°C
- Kelembapan: {$hum}%
- Kecepatan angin: {$wind} km/h
- Tekanan udara: {$pressure} hPa
- Kondisi: {$condKey}

Balaskan HANYA dalam format JSON valid (tanpa backtick, tanpa markdown) seperti ini:
{
  "tanaman": [
    {
      "nama": "Padi",
      "emoji": "🌾",
      "deskripsi": "Kalimat singkat mengapa cocok dengan cuaca ini.",
      "tips": "Tips praktis 1 kalimat.",
      "tags": ["Pangan Utama", "Lahan Basah"],
      "skor": 92
    }
  ]
}

Pilih tanaman yang relevan untuk petani Indonesia (padi, jagung, cabai, tomat, bayam, kangkung, kedelai, singkong, bawang merah, timun, dll). Urutkan dari skor tertinggi. Skor 0-100 berdasarkan kesesuaian cuaca.
PROMPT;
    }

    /**
     * Fallback recommendation (rule-based) when no Gemini key
     */
    private function getFallbackRekomendasi(array $weather): array
    {
        $temp = $weather['temp'] ?? 28;
        $hum  = $weather['humidity'] ?? 75;

        $crops = [
            ['nama' => 'Padi',         'emoji' => '🌾', 'tags' => ['Pangan Utama', 'Lahan Basah'],
             'deskripsi' => 'Cocok dengan kelembapan tinggi dan suhu hangat saat ini.',
             'tips'      => 'Ideal pada suhu 22–32°C dan kelembapan >70%.',
             'range_temp' => [22, 32], 'range_hum' => [70, 90]],

            ['nama' => 'Jagung',       'emoji' => '🌽', 'tags' => ['Pangan', 'Pakan Ternak'],
             'deskripsi' => 'Tumbuh optimal pada suhu hangat dengan kelembapan sedang.',
             'tips'      => 'Cocok suhu 20–35°C. Tahan kekeringan sedang.',
             'range_temp' => [20, 35], 'range_hum' => [50, 80]],

            ['nama' => 'Kedelai',      'emoji' => '🫛', 'tags' => ['Legum', 'Protein Nabati'],
             'deskripsi' => 'Legum yang memperbaiki kesuburan tanah.',
             'tips'      => 'Membutuhkan suhu 20–30°C dan drainase baik.',
             'range_temp' => [20, 30], 'range_hum' => [55, 75]],

            ['nama' => 'Kangkung',     'emoji' => '🥬', 'tags' => ['Sayuran', 'Panen Cepat'],
             'deskripsi' => 'Sayuran hijau yang tumbuh cepat di kondisi lembap.',
             'tips'      => 'Sangat adaptif. Cocok di lahan basah.',
             'range_temp' => [20, 35], 'range_hum' => [60, 90]],

            ['nama' => 'Cabai',        'emoji' => '🌶️', 'tags' => ['Hortikultura', 'Nilai Tinggi'],
             'deskripsi' => 'Komoditas bernilai tinggi. Cocok saat cuaca cerah.',
             'tips'      => 'Butuh sinar penuh. Hindari hujan berlebihan.',
             'range_temp' => [22, 32], 'range_hum' => [50, 70]],

            ['nama' => 'Tomat',        'emoji' => '🍅', 'tags' => ['Hortikultura', 'Sayuran Buah'],
             'deskripsi' => 'Sayuran buah yang disukai pasar lokal.',
             'tips'      => 'Optimal 15–30°C. Perlu trellis dan drainase baik.',
             'range_temp' => [15, 30], 'range_hum' => [50, 70]],

            ['nama' => 'Singkong',     'emoji' => '🍠', 'tags' => ['Pangan', 'Tahan Kering'],
             'deskripsi' => 'Tanaman pangan tahan kering yang produktif.',
             'tips'      => 'Bisa tumbuh di lahan kurang subur.',
             'range_temp' => [20, 35], 'range_hum' => [40, 80]],

            ['nama' => 'Bayam',        'emoji' => '🥗', 'tags' => ['Sayuran', 'Panen Cepat'],
             'deskripsi' => 'Sayuran gizi tinggi, siklus panen singkat.',
             'tips'      => 'Panen dalam 3–4 minggu pada suhu 18–30°C.',
             'range_temp' => [18, 30], 'range_hum' => [50, 80]],

            ['nama' => 'Bawang Merah', 'emoji' => '🧅', 'tags' => ['Bumbu', 'Nilai Tinggi'],
             'deskripsi' => 'Komoditas bumbu dapur bernilai ekonomi tinggi.',
             'tips'      => 'Butuh musim kering dengan kelembapan 50–70%.',
             'range_temp' => [25, 32], 'range_hum' => [50, 70]],

            ['nama' => 'Timun',        'emoji' => '🥒', 'tags' => ['Sayuran', 'Panen Cepat'],
             'deskripsi' => 'Menyukai cuaca hangat dan lembap sedang.',
             'tips'      => 'Panen 35–40 hari setelah tanam.',
             'range_temp' => [22, 32], 'range_hum' => [55, 80]],
        ];

        // Score each crop
        foreach ($crops as &$crop) {
            $score = 100;
            [$tMin, $tMax] = $crop['range_temp'];
            [$hMin, $hMax] = $crop['range_hum'];
            if ($temp < $tMin) $score -= ($tMin - $temp) * 4;
            elseif ($temp > $tMax) $score -= ($temp - $tMax) * 4;
            if ($hum < $hMin) $score -= ($hMin - $hum) * 1.5;
            elseif ($hum > $hMax) $score -= ($hum - $hMax) * 1.5;
            $crop['skor'] = max(0, min(100, (int) round($score)));
        }

        usort($crops, fn ($a, $b) => $b['skor'] - $a['skor']);

        return array_slice($crops, 0, 6);
    }
}
