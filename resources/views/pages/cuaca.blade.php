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
.emoji{font-size:4rem;margin-bottom:.5rem;}
.temp-big{font-family:var(--font-display);font-size:3.5rem;font-weight:700;color:var(--green-dark);}
.city-name{font-size:1.2rem;font-weight:600;color:var(--green-dark);margin:.25rem 0;}
.desc{color:var(--gray-500);text-transform:capitalize;}
.weather-stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;}
.ws-item{text-align:center;background:var(--green-mist);border-radius:10px;padding:.75rem .5rem;}
.ws-item .icon{font-size:1.2rem;margin-bottom:.25rem;}
.ws-item .v{font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--green-dark);}
.ws-item .l{font-size:.72rem;color:var(--gray-500);margin-top:.15rem;}
.demo-badge{background:#fff3cd;color:#856404;border:1px solid #ffc107;border-radius:8px;padding:.5rem 1rem;font-size:.82rem;margin-top:1rem;display:inline-block;}
/* Rekom inline */
.rekom-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;}
.rekom-card{background:var(--white);border-radius:14px;border:1px solid var(--gray-200);overflow:hidden;transition:transform .2s,box-shadow .2s;}
.rekom-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-lg);}
.rekom-card-header{height:80px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;}
.rekom-card-body{padding:1rem;}
.rekom-card-body h4{font-weight:700;color:var(--green-dark);margin-bottom:.4rem;}
.rekom-card-body p{font-size:.82rem;color:var(--gray-500);line-height:1.6;}
.rekom-badges{display:flex;flex-wrap:wrap;gap:.35rem;margin:.75rem 0;}
.rekom-badge{background:var(--green-pale);color:var(--green-mid);padding:.2rem .55rem;border-radius:100px;font-size:.72rem;font-weight:500;}
.score-bar{height:5px;background:var(--gray-200);border-radius:100px;overflow:hidden;margin-top:.5rem;}
.score-fill{height:100%;border-radius:100px;transition:width .8s ease;}
@media(max-width:600px){.weather-stats-row{grid-template-columns:repeat(2,1fr);}.rekom-grid{grid-template-columns:1fr;}}
@endsection

@section('content')
<div class="cuaca-hero">
  <h1>Monitoring Cuaca Pertanian</h1>
  <p>Cari nama kota atau wilayah untuk mendapatkan data cuaca terkini yang akurat.</p>
  <div class="search-bar-wrap">
    <input type="text" id="cuaca-city" placeholder="Ketik nama kota... (contoh: Surakarta, Klaten, Boyolali)"/>
    <button class="btn btn-primary" onclick="fetchWeather()">Cari</button>
  </div>
</div>

<div style="padding:0 2rem 60px;max-width:800px;margin:0 auto;">
  <div id="weather-loading" style="display:none;margin-top:2rem;"><div class="spinner"></div><p style="text-align:center;color:var(--gray-500);">Mengambil data cuaca...</p></div>
  <div id="weather-error" style="display:none;background:#ffebee;border-radius:var(--radius);padding:1.25rem 1.5rem;color:#c62828;margin-top:2rem;font-size:.9rem;"></div>
  <div id="weather-result" style="display:none;">
    <div class="weather-big-card">
      <div class="weather-big-display">
        <div class="emoji" id="w-emoji">☀️</div>
        <div class="temp-big" id="w-temp">--°C</div>
        <div class="city-name" id="w-city">--</div>
        <div class="desc" id="w-desc">--</div>
        <div id="demo-notice" style="display:none;" class="demo-badge">⚠️ Mode Demo — Atur <code>OWM_API_KEY</code> di .env untuk data real-time</div>
      </div>
      <div class="weather-stats-row">
        <div class="ws-item"><div class="icon">💧</div><div class="v" id="w-hum">-</div><div class="l">Kelembapan</div></div>
        <div class="ws-item"><div class="icon">💨</div><div class="v" id="w-wind">-</div><div class="l">Angin</div></div>
        <div class="ws-item"><div class="icon">📊</div><div class="v" id="w-pressure">-</div><div class="l">Tekanan</div></div>
        <div class="ws-item"><div class="icon">🌡️</div><div class="v" id="w-feels">-</div><div class="l">Feels Like</div></div>
      </div>
    </div>
    <div id="cuaca-rekom" style="display:none;margin-top:2rem;">
      <h3 style="font-family:var(--font-display);font-size:1.4rem;color:var(--green-dark);margin-bottom:1rem;">🌱 Rekomendasi Tanam Berdasarkan Cuaca Ini</h3>
      <div id="cuaca-rekom-grid" class="rekom-grid"></div>
    </div>
  </div>
  <div id="weather-empty" style="text-align:center;padding:4rem 2rem;color:var(--gray-500);">
    <div style="font-size:3.5rem;margin-bottom:1rem;">🌤️</div>
    <h3 style="font-family:var(--font-display);color:var(--green-dark);margin-bottom:.5rem;">Mulai dengan Mencari Lokasi</h3>
    <p>Ketik nama kota atau wilayah Anda di kotak pencarian untuk melihat informasi cuaca terkini.</p>
  </div>
</div>

<footer style="background:var(--gray-900);padding:2rem;text-align:center;color:rgba(255,255,255,.5);font-size:.82rem;">
  © {{ date('Y') }} Atamagri · <a href="{{ route('landing') }}" style="color:#7bbf7b;">Kembali ke Beranda</a>
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

  document.getElementById('weather-empty').style.display = 'none';
  document.getElementById('weather-result').style.display = 'none';
  document.getElementById('weather-error').style.display = 'none';
  document.getElementById('weather-loading').style.display = 'block';
  document.getElementById('cuaca-rekom').style.display = 'none';

  try {
    const res = await fetch('{{ route("api.cuaca") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({ city }),
    });

    const json = await res.json();
    document.getElementById('weather-loading').style.display = 'none';

    if (!json.success) {
      document.getElementById('weather-error').textContent = '⚠️ ' + json.message;
      document.getElementById('weather-error').style.display = 'block';
      return;
    }

    const d = json.data;
    document.getElementById('w-emoji').textContent    = d.emoji;
    document.getElementById('w-temp').textContent     = d.temp + '°C';
    document.getElementById('w-city').textContent     = d.name + ', ' + d.country;
    document.getElementById('w-desc').textContent     = d.description;
    document.getElementById('w-hum').textContent      = d.humidity + '%';
    document.getElementById('w-wind').textContent     = d.wind_speed + ' km/h';
    document.getElementById('w-pressure').textContent = d.pressure + ' hPa';
    document.getElementById('w-feels').textContent    = d.feels_like + '°C';
    document.getElementById('demo-notice').style.display = d.demo ? 'inline-block' : 'none';
    document.getElementById('weather-result').style.display = 'block';

    // Fetch rekomendasi too
    fetchRekomInline(city, d);

  } catch (e) {
    document.getElementById('weather-loading').style.display = 'none';
    document.getElementById('weather-error').textContent = '⚠️ Gagal terhubung ke server.';
    document.getElementById('weather-error').style.display = 'block';
  }
}

async function fetchRekomInline(city, weatherData) {
  try {
    const res = await fetch('{{ route("api.rekomendasi") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({ city, weather: weatherData }),
    });
    const json = await res.json();
    if (json.success) {
      buildRekomCards(json.rekomendasi, 'cuaca-rekom-grid');
      document.getElementById('cuaca-rekom').style.display = 'block';
    }
  } catch (e) { /* silent fail */ }
}

function buildRekomCards(crops, containerId) {
  const container = document.getElementById(containerId);
  if (!container) return;
  container.innerHTML = crops.slice(0, 6).map(c => `
    <div class="rekom-card">
      <div class="rekom-card-header" style="background:${c.bg || '#e8f5e8'};">${c.emoji}</div>
      <div class="rekom-card-body">
        <h4>${c.nama}</h4>
        <p>${c.deskripsi}</p>
        <p style="font-size:.8rem;color:var(--green-mid);margin-top:.4rem;font-style:italic;">💡 ${c.tips}</p>
        <div class="rekom-badges">${(c.tags||[]).map(t=>`<span class="rekom-badge">${t}</span>`).join('')}</div>
        <div class="score-bar"><div class="score-fill" style="width:${c.skor}%;background:${scoreColor(c.skor)};"></div></div>
        <div style="font-size:.75rem;font-weight:700;color:${scoreColor(c.skor)};margin-top:.3rem;">Kesesuaian: ${c.skor}%</div>
      </div>
    </div>`).join('');
}

function scoreColor(s) {
  if (s >= 80) return 'var(--green-light)';
  if (s >= 60) return '#f9c74f';
  return '#e57373';
}
</script>
@endsection
