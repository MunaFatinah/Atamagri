<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\RekomendasiController;

/*
|--------------------------------------------------------------------------
| API Routes — Atamagri
|--------------------------------------------------------------------------
| Prefix otomatis: /api/...
| Contoh: POST /api/cuaca, POST /api/rekomendasi
|--------------------------------------------------------------------------
*/

// ═══════════════════════════════════════
// PUBLIC API (tanpa auth)
// ═══════════════════════════════════════

Route::prefix('v1')->group(function () {

    // --- Cuaca ---
    // POST /api/v1/cuaca
    // Body: { "city": "Surakarta" }
    Route::post('/cuaca', [WeatherController::class, 'fetch'])->name('api.v1.cuaca');

    // GET /api/v1/cuaca?city=Surakarta
    Route::get('/cuaca', function (\Illuminate\Http\Request $request) {
        $request->validate(['city' => 'required|string|max:100']);
        $wc = app(WeatherController::class);
        $data = $wc->getWeather($request->city);
        if (isset($data['error'])) {
            return response()->json(['success' => false, 'message' => $data['error']], 422);
        }
        return response()->json(['success' => true, 'data' => $data]);
    })->name('api.v1.cuaca.get');

    // --- Rekomendasi ---
    // POST /api/v1/rekomendasi
    // Body: { "city": "Surakarta" }
    Route::post('/rekomendasi', [RekomendasiController::class, 'fetch'])->name('api.v1.rekomendasi');

    // --- Health check ---
    // GET /api/v1/ping
    Route::get('/ping', function () {
        return response()->json([
            'success' => true,
            'app'     => 'Atamagri API',
            'version' => 'v1',
            'status'  => 'ok',
            'time'    => now()->toISOString(),
            'services' => [
                'owm_api'    => config('services.owm.key') && config('services.owm.key') !== 'YOUR_OWM_API_KEY_HERE' ? 'connected' : 'demo_mode',
                'gemini_api' => config('services.gemini.key') && config('services.gemini.key') !== 'YOUR_GEMINI_API_KEY_HERE' ? 'connected' : 'fallback_mode',
            ],
        ]);
    })->name('api.v1.ping');

});

// ═══════════════════════════════════════
// PROTECTED API (butuh login / Sanctum)
// ═══════════════════════════════════════

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    // GET /api/v1/user — info user yang sedang login
    Route::get('/user', function (\Illuminate\Http\Request $request) {
        return response()->json([
            'success' => true,
            'user'    => [
                'id'       => $request->user()->id,
                'name'     => $request->user()->name,
                'email'    => $request->user()->email,
                'role'     => $request->user()->role,
                'location' => $request->user()->location,
            ],
        ]);
    })->name('api.v1.user');

    // POST /api/v1/dashboard/cuaca
    Route::post('/dashboard/cuaca', [WeatherController::class, 'fetchDash'])->name('api.v1.dashboard.cuaca');

    // POST /api/v1/dashboard/rekomendasi
    Route::post('/dashboard/rekomendasi', [RekomendasiController::class, 'fetchDash'])->name('api.v1.dashboard.rekomendasi');

});
