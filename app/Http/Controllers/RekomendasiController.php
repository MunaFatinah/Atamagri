<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RekomendasiController extends Controller
{
    private string $geminiKey;
    private string $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->geminiKey = config('services.gemini.key', env('GEMINI_API_KEY', ''));
    }

    public function index()
    {
        return view('pages.rekomendasi');
    }

    public function fetch(Request $request)
    {
        $request->validate([
            'city'     => 'required|string|max:100',
            'weather'  => 'nullable|array',
        ]);

        $weather = $request->weather;
        if (!$weather) {
            $wc      = app(WeatherController::class);
            $weather = $wc->getWeather($request->city);
            if (isset($weather['error'])) {
                return response()->json(['success' => false, 'message' => $weather['error']], 422);
            }
        }

        $rekomendasi = $this->getGeminiRekomendasi($weather, $request->city);

        if (empty($rekomendasi)) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan rekomendasi dari Gemini AI. Coba beberapa saat lagi.',
            ], 503);
        }

        return response()->json([
            'success'     => true,
            'weather'     => $weather,
            'rekomendasi' => $rekomendasi,
        ]);
    }

    public function fetchDash(Request $request)
    {
        return $this->fetch($request);
    }

    private function getGeminiRekomendasi(array $weather, string $city): array
    {
        if (empty($this->geminiKey) || $this->geminiKey === 'YOUR_GEMINI_API_KEY_HERE') {
            return [];
        }

        $prompt = $this->buildPrompt($weather, $city);

        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Accept'       => 'application/json',
                ])
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
                        'temperature'      => 0.3,
                        'maxOutputTokens'  => 8192,
                        'responseMimeType' => 'application/json',
                    ],
                ]);

            if ($response->failed()) {
                Log::warning('Gemini API failed: ' . $response->status() . ' - ' . $response->body());
                return [];
            }

            $body = json_decode($response->body(), true, 512, JSON_UNESCAPED_UNICODE);
            $text = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';
            $text = trim($text);

            $text = preg_replace('/^```json\s*/m', '', $text);
            $text = preg_replace('/```$/m', '', $text);
            $text = trim($text);

            $parsed = json_decode($text, true, 512, JSON_UNESCAPED_UNICODE);

            if (!$parsed || !isset($parsed['tanaman'])) {
                Log::warning('Gemini response parse failed: ' . $text);
                return [];
            }

            return $parsed['tanaman'];

        } catch (\Exception $e) {
            Log::error('Gemini error: ' . $e->getMessage());
            return [];
        }
    }

    private function buildPrompt(array $weather, string $city): string
    {
        $temp     = $weather['temp'] ?? 28;
        $hum      = $weather['humidity'] ?? 75;
        $wind     = $weather['wind_speed'] ?? 10;
        $pressure = $weather['pressure'] ?? 1010;
        $condKey  = $weather['cond_key'] ?? 'clouds';

        return <<<PROMPT
Rekomendasikan 6 tanaman untuk petani di {$city} berdasarkan cuaca: suhu {$temp}°C, kelembapan {$hum}%, angin {$wind} km/h, tekanan {$pressure} hPa, kondisi {$condKey}.

Balas JSON saja, tanpa teks lain:
{"tanaman":[{"nama":"...","emoji":"...","deskripsi":"maks 10 kata","tips":"maks 10 kata","tags":["...","..."],"skor":0}]}

Tanaman: padi, jagung, cabai, tomat, bayam, kangkung, kedelai, singkong, bawang merah, timun. Skor 0-100.
PROMPT;
    }
}