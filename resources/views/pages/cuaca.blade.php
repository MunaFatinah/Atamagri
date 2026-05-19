@extends('layouts.app')
@section('title', 'Monitoring Cuaca')

@section('extra-styles')
.cuaca-hero{background:linear-gradient(160deg,var(--green-dark) 0%,var(--green-mid) 100%);padding:120px 2rem 60px;text-align:center;color:var(--white);}
.cuaca-hero h1{font-family:var(--font-display);font-size:2.5rem;font-weight:700;margin-bottom:.75rem;}
.cuaca-hero p{color:rgba(255,255,255,.7);margin-bottom:2rem;}
.search-bar-wrap{display:flex;gap:.75rem;max-width:520px;margin:0 auto;}
.search-bar-wrap input{flex:1;padding:.8rem 1.2rem;border-radius:var(--radius);border:none;font-family:var(--font-body);font-size:.95rem;outline:none;}
.weather-big-card{background:var(--white);border-radius:20px;padding:2rem;box-shadow:var(--shadow-lg);margin-top:2rem;}
.weather-big-display{text-align:center;padding-bottom:1.5rem;border-bottom:1px solid var(--gray-200);margin-bottom:1.5rem;}
.w-emoji{font-size:4rem;margin-bottom:.5rem;}
.temp-big{font-family:var(--font-display);font-size:3.5rem;font-weight:700;color:var(--green-dark);}
.city-name{font-size:1.2rem;font-weight:600;color:var(--green-dark);margin:.25rem 0;}
.w-desc{color:var(--gray-500);text-transform:capitalize;}
.weather-stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;}
.ws-item{text-align:center;background:var(--green-mist);border-radius:10px;padding:.75rem .5rem;}
.ws-item .icon{font-size:1.2rem;margin-bottom:.25rem;}
.ws-item .v{font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--green-dark);}
.ws-item .l{font-size:.72rem;color:var(--gray-500);margin-top:.15rem;}
.demo-badge{background:#fff3cd;color:#856404;border:1px solid #ffc107;border-radius:8px;padding:.5rem 1rem;font-size:.82rem;margin-top:1rem;display:inline-block;}
@media(max-width:600px){.weather-stats-row{grid-template-columns:repeat(2,1fr);}}
@endsection

@section('content')
<div class="cuaca-hero">
  <h1>Monitoring Cuaca Pertanian</h1>
  <p>Cari nama kota untuk data cuaca terkini.</p>
  <div class="search-bar-wrap">
    <input type="text" id="cuaca-city" placeholder="Ketik nama kota... (contoh: Malang, Klaten, Boyolali)"/>
    <button class="btn btn-primary" onclick="fetchWeather()">Cari</button>
  </div>
</div>

<div style="padding:0 2rem 60px;max-width:860px;margin:0 auto;">
  <div id="weather-loading" style="display:none;margin-top:2rem;">
    <div class="spinner"></div>
    <p style="text-align:center;color:var(--gray-500);">Mengambil data cuaca...</p>
  </div>
  <div id="weather-error" style="display:none;background:#ffebee;border-radius:var(--radius);padding:1.25rem 1.5rem;color:#c62828;margin-top:2rem;font-size:.9rem;"></div>

  <div id="weather-result" style="display:none;">
    <div class="weather-big-card">
      <div class="weather-big-display">
        <div class="w-emoji" id="w-emoji">☀️</div>
        <div class="temp-big" id="w-temp">--°C</div>
        <div class="city-name" id="w-city">--</div>
        <div class="w-desc" id="w-desc">--</div>
        <div id="demo-notice" style="display:none;" class="demo-badge">⚠️ Mode Demo — Atur <code>OWM_API_KEY</code> di .env untuk data real-time</div>
      </div>
      <div class="weather-stats-row">
        <div class="ws-item"><div class="icon">💧</div><div class="v" id="w-hum">-</div><div class="l">Kelembapan</div></div>
        <div class="ws-item"><div class="icon">💨</div><div class="v" id="w-wind">-</div><div class="l">Angin</div></div>
        <div class="ws-item"><div class="icon">📊</div><div class="v" id="w-pressure">-</div><div class="l">Tekanan</div></div>
        <div class="ws-item"><div class="icon">🌡️</div><div class="v" id="w-feels">-</div><div class="l">Feels Like</div></div>
      </div>
    </div>
  </div>

  <div id="weather-empty" style="text-align:center;padding:4rem 2rem;color:var(--gray-500);">
    <div style="font-size:3.5rem;margin-bottom:1rem;">🌤️</div>
    <h3 style="font-family:var(--font-display);color:var(--green-dark);margin-bottom:.5rem;">Mulai dengan Mencari Lokasi</h3>
    <p>Ketik nama kota Anda untuk melihat cuaca terkini.</p>
  </div>
</div>

<footer style="width:100%;height:57px;background-color:#1a1a18;display:flex;align-items:center;justify-content:center;">
  <span style="font-family:var(--font-body);font-weight:400;color:#ffffff;font-size:17px;text-align:center;letter-spacing:0;line-height:normal;">© {{ date('Y') }} Atamagri</span>
</footer>
@endsection

@section('scripts')
<script>
document.getElementById('cuaca-city').addEventListener('keydown', e => {
  if (e.key === 'Enter') fetchWeather();
});

async function fetchWeather() {
  const city = document.getElementById('cuaca-city').value.trim();
  if (!city) { showToast('Masukkan nama kota terlebih dahulu', '⚠️'); return; }

  hide('weather-empty'); hide('weather-result'); hide('weather-error');
  show('weather-loading');

  try {
    const res = await apiFetch('{{ route("api.cuaca") }}', { city });
    hide('weather-loading');

    if (!res.success) {
      document.getElementById('weather-error').textContent = '⚠️ ' + res.message;
      show('weather-error'); return;
    }

    const d = res.data;
    document.getElementById('w-emoji').textContent    = d.emoji;
    document.getElementById('w-temp').textContent     = d.temp + '°C';
    document.getElementById('w-city').textContent     = d.name + ', ' + d.country;
    document.getElementById('w-desc').textContent     = d.description;
    document.getElementById('w-hum').textContent      = d.humidity + '%';
    document.getElementById('w-wind').textContent     = d.wind_speed + ' km/h';
    document.getElementById('w-pressure').textContent = d.pressure + ' hPa';
    document.getElementById('w-feels').textContent    = d.feels_like + '°C';
    document.getElementById('demo-notice').style.display = d.demo ? 'inline-block' : 'none';
    show('weather-result');

  } catch (e) {
    hide('weather-loading');
    document.getElementById('weather-error').textContent = '⚠️ Gagal terhubung ke server.';
    show('weather-error');
  }
}

function show(id) { document.getElementById(id).style.display = 'block'; }
function hide(id) { document.getElementById(id).style.display = 'none'; }

async function apiFetch(url, body) {
  const res = await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify(body),
  });
  return res.json();
}
</script>
@endsection