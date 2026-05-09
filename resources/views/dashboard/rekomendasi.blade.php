@extends('layouts.dashboard')
@section('title', 'Rekomendasi — Dashboard')

@section('extra-styles')
.search-bar-wrap{display:flex;gap:.75rem;}
.search-bar-wrap input{flex:1;padding:.75rem 1rem;border-radius:var(--radius);border:1.5px solid var(--gray-200);font-family:var(--font-body);font-size:.9rem;outline:none;}
.search-bar-wrap input:focus{border-color:var(--green-light);}
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
.weather-info-bar{background:linear-gradient(135deg,var(--green-dark),var(--green-mid));border-radius:16px;padding:1.5rem;color:var(--white);margin-bottom:1.5rem;display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:1rem;text-align:center;}
.weather-info-bar .big{font-family:var(--font-display);font-size:1.8rem;font-weight:700;}
.weather-info-bar .lbl{font-size:.82rem;opacity:.7;margin-top:.25rem;}
.ai-badge{display:inline-flex;align-items:center;gap:.4rem;background:linear-gradient(135deg,#4285f4,#34a853);color:#fff;padding:.25rem .75rem;border-radius:100px;font-size:.78rem;font-weight:600;}
@media(max-width:700px){.rekom-grid{grid-template-columns:1fr 1fr;}.weather-info-bar{grid-template-columns:1fr 1fr;}}
@endsection

@section('sidebar-menu')
<div class="sidebar-section">Menu</div>
<a class="sidebar-item" href="{{ route('dashboard.index') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
  <span>Dashboard</span>
</a>
<a class="sidebar-item" href="{{ route('dashboard.cuaca') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.79 1.42-1.41zM4 10.5H1v2h3v-2zm9-9.95h-2V3.5h2V.55zm7.45 3.91l-1.41-1.41-1.79 1.79 1.41 1.41 1.79-1.79zm-3.21 13.7l1.79 1.8 1.41-1.41-1.8-1.79-1.4 1.4zM20 10.5v2h3v-2h-3zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm-1 16.95h2V19.5h-2v2.95zm-7.45-3.91l1.41 1.41 1.79-1.8-1.41-1.41-1.79 1.8z"/></svg>
  <span>Cuaca</span>
</a>
<a class="sidebar-item active" href="{{ route('dashboard.rekomendasi') }}">
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
  <div><h1>Rekomendasi Tanam</h1><p>Rekomendasi tanaman berdasarkan kondisi cuaca saat ini via Gemini AI.</p></div>
  <span class="ai-badge">✨ Gemini AI</span>
</div>
<div class="main-body">
  <div class="card" style="margin-bottom:1.5rem;">
    <div class="card-body">
      <div class="search-bar-wrap">
        <input type="text" id="rekom-city-input" placeholder="Masukkan nama kota... (contoh: Boyolali, Klaten)" value="{{ $user->location }}"/>
        <button class="btn btn-primary" onclick="fetchRekomendasiDash()">Dapatkan Rekomendasi</button>
      </div>
    </div>
  </div>

  <div id="rekom-dash-loading" style="display:none;"><div class="spinner"></div><p style="text-align:center;color:var(--gray-500);">Menganalisis cuaca dengan AI...</p></div>

  <div id="rekom-weather-info" style="display:none;" class="weather-info-bar">
    <div><div style="font-size:2rem;" id="ri-icon">☀️</div><div class="big" id="ri-temp">-</div><div class="lbl">Suhu</div></div>
    <div><div style="font-size:2rem;">💧</div><div class="big" id="ri-hum">-</div><div class="lbl">Kelembapan</div></div>
    <div><div style="font-size:2rem;">💨</div><div class="big" id="ri-wind">-</div><div class="lbl">Angin</div></div>
    <div><div style="font-size:2rem;">📍</div><div class="big" style="font-size:1.1rem;margin-top:.3rem;" id="ri-city">-</div><div class="lbl">Lokasi</div></div>
  </div>

  <div id="rekom-list-dash"></div>

  <div id="rekom-dash-empty" style="text-align:center;padding:3rem;color:var(--gray-500);">
    <div style="font-size:3rem;margin-bottom:1rem;">🌱</div>
    <p>Masukkan nama kota untuk mendapatkan rekomendasi tanam dari AI.</p>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('rekom-city-input').addEventListener('keydown', e => {
  if (e.key === 'Enter') fetchRekomendasiDash();
});

async function fetchRekomendasiDash() {
  const city = document.getElementById('rekom-city-input').value.trim();
  if (!city) { showToast('Masukkan nama kota', '⚠️'); return; }
  document.getElementById('rekom-dash-empty').style.display = 'none';
  document.getElementById('rekom-list-dash').innerHTML = '';
  document.getElementById('rekom-weather-info').style.display = 'none';
  document.getElementById('rekom-dash-loading').style.display = 'block';
  try {
    const res = await fetch('{{ route("dashboard.api.rekomendasi") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
      body: JSON.stringify({ city }),
    });
    const json = await res.json();
    document.getElementById('rekom-dash-loading').style.display = 'none';
    if (!json.success) { showToast(json.message, '⚠️'); return; }
    const w = json.weather;
    document.getElementById('ri-icon').textContent = w.emoji;
    document.getElementById('ri-temp').textContent = w.temp + '°C';
    document.getElementById('ri-hum').textContent  = w.humidity + '%';
    document.getElementById('ri-wind').textContent = w.wind_speed + ' km/h';
    document.getElementById('ri-city').textContent = w.name;
    document.getElementById('rekom-weather-info').style.display = 'grid';
    buildRekomCards(json.rekomendasi, 'rekom-list-dash');
  } catch(e) {
    document.getElementById('rekom-dash-loading').style.display = 'none';
    showToast('Gagal terhubung ke server', '⚠️');
  }
}

function buildRekomCards(crops, containerId) {
  const container = document.getElementById(containerId);
  if (!container) return;
  container.innerHTML = `<div class="rekom-grid">${crops.slice(0,6).map(c => `
    <div class="rekom-card">
      <div class="rekom-card-header" style="background:${c.bg||'#e8f5e8'};">${c.emoji}</div>
      <div class="rekom-card-body">
        <h4>${c.nama}</h4>
        <p>${c.deskripsi}</p>
        <p style="font-size:.8rem;color:var(--green-mid);margin-top:.4rem;font-style:italic;">💡 ${c.tips}</p>
        <div class="rekom-badges">${(c.tags||[]).map(t=>`<span class="rekom-badge">${t}</span>`).join('')}</div>
        <div class="score-bar"><div class="score-fill" style="width:${c.skor}%;background:${scoreColor(c.skor)};"></div></div>
        <div style="font-size:.75rem;font-weight:700;color:${scoreColor(c.skor)};margin-top:.3rem;">Kesesuaian: ${c.skor}%</div>
      </div>
    </div>`).join('')}</div>`;
}

function scoreColor(s){return s>=80?'var(--green-light)':s>=60?'#f9c74f':'#e57373';}

window.addEventListener('DOMContentLoaded', () => {
  const city = document.getElementById('rekom-city-input').value.trim();
  if (city) fetchRekomendasiDash();
});
</script>
@endsection
