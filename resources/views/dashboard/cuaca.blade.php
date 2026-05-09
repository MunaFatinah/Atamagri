@extends('layouts.dashboard')
@section('title', 'Cuaca — Dashboard')

@section('extra-styles')
.search-bar-wrap{display:flex;gap:.75rem;}
.search-bar-wrap input{flex:1;padding:.75rem 1rem;border-radius:var(--radius);border:1.5px solid var(--gray-200);font-family:var(--font-body);font-size:.9rem;outline:none;}
.search-bar-wrap input:focus{border-color:var(--green-light);}
.ww-stat{background:var(--green-mist);border-radius:10px;padding:.75rem .5rem;text-align:center;}
.ww-stat .icon{font-size:1.2rem;margin-bottom:.25rem;}
.ww-stat .v{font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--green-dark);}
.ww-stat .l{font-size:.72rem;color:var(--gray-500);margin-top:.15rem;}
@endsection

@section('sidebar-menu')
<div class="sidebar-section">Menu</div>
<a class="sidebar-item" href="{{ route('dashboard.index') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
  <span>Dashboard</span>
</a>
<a class="sidebar-item active" href="{{ route('dashboard.cuaca') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.79 1.42-1.41zM4 10.5H1v2h3v-2zm9-9.95h-2V3.5h2V.55zm7.45 3.91l-1.41-1.41-1.79 1.79 1.41 1.41 1.79-1.79zm-3.21 13.7l1.79 1.8 1.41-1.41-1.8-1.79-1.4 1.4zM20 10.5v2h3v-2h-3zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm-1 16.95h2V19.5h-2v2.95zm-7.45-3.91l1.41 1.41 1.79-1.8-1.41-1.41-1.79 1.8z"/></svg>
  <span>Cuaca</span>
</a>
<a class="sidebar-item" href="{{ route('dashboard.rekomendasi') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 0 0 8 20c9 0 14-8 14-8-1 2-4 5-5 5-3 0-3-2.5-5-2.5S9 17 6 17c1-3 4-8 11-9z"/></svg>
  <span>Rekomendasi</span>
</a>
<a class="sidebar-item" href="{{ route('dashboard.profil') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
  <span>Profil Saya</span>
</a>
@endsection

@section('content')
<div class="main-header">
  <div><h1>Monitoring Cuaca</h1><p>Data cuaca real-time dari OpenWeatherMap API.</p></div>
</div>
<div class="main-body">
  <div class="card" style="margin-bottom:1.5rem;">
    <div class="card-body">
      <div class="search-bar-wrap">
        <input type="text" id="dash-weather-city" placeholder="Masukkan nama kota... (contoh: Surakarta, Boyolali)" value="{{ $user->location }}"/>
        <button class="btn btn-primary" onclick="fetchDashWeather()">Cek Cuaca</button>
      </div>
    </div>
  </div>

  <div id="dash-weather-loading" style="display:none;"><div class="spinner"></div><p style="text-align:center;color:var(--gray-500);">Mengambil data cuaca...</p></div>

  <div id="dash-weather-result" style="display:none;">
    <div class="card">
      <div class="card-body">
        <div style="display:grid;grid-template-columns:auto 1fr;gap:2rem;align-items:center;">
          <div style="text-align:center;">
            <div style="font-size:4rem;" id="dw-icon">☀️</div>
            <div style="font-family:var(--font-display);font-size:3rem;font-weight:700;color:var(--green-dark);" id="dw-temp">--°C</div>
            <div style="color:var(--gray-500);font-size:.9rem;" id="dw-desc">--</div>
          </div>
          <div>
            <div style="font-size:1.2rem;font-weight:700;color:var(--green-dark);margin-bottom:1rem;" id="dw-city">--</div>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;">
              <div class="ww-stat"><div class="icon">💧</div><div class="v" id="dw-hum">-</div><div class="l">Kelembapan</div></div>
              <div class="ww-stat"><div class="icon">💨</div><div class="v" id="dw-wind">-</div><div class="l">Kecepatan Angin</div></div>
              <div class="ww-stat"><div class="icon">📊</div><div class="v" id="dw-pressure">-</div><div class="l">Tekanan Udara</div></div>
              <div class="ww-stat"><div class="icon">🌡️</div><div class="v" id="dw-feels">-</div><div class="l">Feels Like</div></div>
              <div class="ww-stat"><div class="icon">👁️</div><div class="v" id="dw-vis">-</div><div class="l">Jarak Pandang</div></div>
              <div class="ww-stat"><div class="icon">☁️</div><div class="v" id="dw-cloud">-</div><div class="l">Tutupan Awan</div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="dash-weather-empty" style="text-align:center;padding:3rem;color:var(--gray-500);">
    <div style="font-size:3rem;margin-bottom:1rem;">🔍</div>
    <p>Masukkan nama kota untuk melihat cuaca terkini.</p>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('dash-weather-city').addEventListener('keydown', e => {
  if (e.key === 'Enter') fetchDashWeather();
});

async function fetchDashWeather() {
  const city = document.getElementById('dash-weather-city').value.trim();
  if (!city) { showToast('Masukkan nama kota', '⚠️'); return; }
  document.getElementById('dash-weather-empty').style.display = 'none';
  document.getElementById('dash-weather-result').style.display = 'none';
  document.getElementById('dash-weather-loading').style.display = 'block';
  try {
    const res = await fetch('{{ route("dashboard.api.cuaca") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
      body: JSON.stringify({ city }),
    });
    const json = await res.json();
    document.getElementById('dash-weather-loading').style.display = 'none';
    if (!json.success) { showToast(json.message, '⚠️'); return; }
    const d = json.data;
    document.getElementById('dw-icon').textContent     = d.emoji;
    document.getElementById('dw-temp').textContent     = d.temp + '°C';
    document.getElementById('dw-city').textContent     = '📍 ' + d.name + ', ' + d.country;
    document.getElementById('dw-desc').textContent     = d.description;
    document.getElementById('dw-hum').textContent      = d.humidity + '%';
    document.getElementById('dw-wind').textContent     = d.wind_speed + ' km/h';
    document.getElementById('dw-pressure').textContent = d.pressure + ' hPa';
    document.getElementById('dw-feels').textContent    = d.feels_like + '°C';
    document.getElementById('dw-vis').textContent      = d.visibility ? d.visibility + ' km' : '-';
    document.getElementById('dw-cloud').textContent    = d.clouds + '%';
    document.getElementById('dash-weather-result').style.display = 'block';
  } catch(e) { document.getElementById('dash-weather-loading').style.display = 'none'; showToast('Gagal terhubung', '⚠️'); }
}

// Auto-load jika ada lokasi
window.addEventListener('DOMContentLoaded', () => {
  const city = document.getElementById('dash-weather-city').value.trim();
  if (city) fetchDashWeather();
});
</script>
@endsection
