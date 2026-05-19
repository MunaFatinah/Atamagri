<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    private string $geminiKey;
    private string $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
    public function __construct()
    {
        $this->geminiKey = config('services.gemini.key', env('GEMINI_API_KEY', ''));
    }

    public function chat(Request $request)
    {
        $request->validate([
            'history' => 'required|array',
            'weather' => 'required|array',
            'city'    => 'required|string',
        ]);

        $history = $request->history;
        $weather = $request->weather;
        $city    = $request->city;

        if (empty($this->geminiKey) || $this->geminiKey === 'YOUR_GEMINI_API_KEY_HERE') {
            return response()->json([
                'reply' => 'Maaf, fitur chat AI belum dikonfigurasi. Tambahkan GEMINI_API_KEY di file .env.'
            ]);
        }

        $systemPrompt = $this->buildSystemPrompt($weather, $city);

        $contents = [];
        foreach ($history as $msg) {
            $role = $msg['role'] === 'model' ? 'model' : 'user';
            $contents[] = [
                'role'  => $role,
                'parts' => [['text' => $msg['content']]],
            ];
        }

        if (empty($contents)) {
            $contents[] = ['role' => 'user',  'parts' => [['text' => $systemPrompt]]];
            $contents[] = ['role' => 'model', 'parts' => [['text' => 'Siap! Saya Pak Tani AI. Ada yang bisa saya bantu?']]];
        } else {
            $contents[0]['parts'][0]['text'] = $systemPrompt;
        }

        try {
            $response = Http::timeout(20)
                ->withQueryParameters(['key' => $this->geminiKey])
                ->post($this->geminiUrl, [
                    'contents'         => $contents,
                    'generationConfig' => [
                        'temperature'     => 0.7,
                        'maxOutputTokens' => 2048,
                    ],
                ]);

            if ($response->failed()) {
                Log::warning('Gemini chat failed: ' . $response->status() . ' | Body: ' . $response->body());
                return response()->json(['reply' => 'AI sedang tidak tersedia. (Error ' . $response->status() . ': ' . $response->body() . ')']);
            }

            $body  = $response->json();
            $reply = $body['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, tidak ada respons dari AI.';

            return response()->json(['reply' => trim($reply)]);

        } catch (\Exception $e) {
            Log::error('Gemini chat error: ' . $e->getMessage());
            return response()->json(['reply' => 'Error: ' . $e->getMessage()]);
        }
    }

    private function buildSystemPrompt(array $weather, string $city): string
    {
        $temp     = $weather['temp'] ?? 28;
        $feels    = $weather['feels_like'] ?? $temp;
        $hum      = $weather['humidity'] ?? 75;
        $wind     = $weather['wind_speed'] ?? 10;
        $pressure = $weather['pressure'] ?? 1010;
        $desc     = $weather['description'] ?? 'berawan';

        $month = (int) date('n');
        $musim = ($month >= 11 || $month <= 4) ? 'musim hujan' : 'musim kemarau';

        return <<<PROMPT
Kamu adalah Pak Tani AI, konsultan pertanian Indonesia yang ramah, praktis, dan berpengalaman. Kamu membantu petani dengan saran konkret berdasarkan kondisi nyata di lapangan.

Konteks lokasi & cuaca saat ini:
- Lokasi: {$city}, Indonesia ({$musim})
- Suhu: {$temp}°C (terasa {$feels}°C)
- Kelembapan: {$hum}%
- Angin: {$wind} km/h
- Tekanan: {$pressure} hPa
- Kondisi langit: {$desc}

Panduan menjawab:
- Jawab singkat dan praktis (2–4 kalimat), kecuali diminta detail
- Selalu kaitkan saran dengan data cuaca di atas jika relevan
- Gunakan bahasa Indonesia yang ramah dan mudah dipahami petani
- Jika ada angka/rekomendasi spesifik, sebutkan dengan jelas
- Jika pertanyaan tidak soal pertanian, arahkan dengan sopan kembali ke topik pertanian
PROMPT;
    }
}