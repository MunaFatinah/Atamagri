@extends('layouts.app')
@section('title', 'Rekomendasi Tanam')

@section('extra-styles')
.rekom-hero{background:linear-gradient(160deg,var(--green-dark) 0%,var(--green-mid) 100%);padding:120px 2rem 60px;text-align:center;color:var(--white);}
.rekom-hero h1{font-family:var(--font-display);font-size:2.5rem;font-weight:700;margin-bottom:.75rem;}
.rekom-hero p{color:rgba(255,255,255,.7);margin-bottom:2rem;}
.search-bar-wrap{display:flex;gap:.75rem;max-width:560px;margin:0 auto;}
.search-bar-wrap input{flex:1;padding:.8rem 1.2rem;border-radius:var(--radius);border:none;font-family:var(--font-body);font-size:.95rem;outline:none;}
.rekom-results{max-width:960px;margin:0 auto;padding:2rem 2rem 60px;}
.weather-strip{background:linear-gradient(135deg,var(--green-dark),var(--green-mid));border-radius:16px;padding:1.5rem;color:var(--white);margin-bottom:2rem;display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:1rem;text-align:center;}
.weather-strip .big{font-family:var(--font-display);font-size:1.8rem;font-weight:700;}
.weather-strip .lbl{font-size:.82rem;opacity:.7;margin-top:.25rem;}
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
.ai-badge{display:inline-flex;align-items:center;gap:.4rem;background:linear-gradient(135deg,#4285f4,#34a853);color:#fff;padding:.25rem .75rem;border-radius:100px;font-size:.78rem;font-weight:600;margin-bottom:1rem;}
@media(max-width:600px){.rekom-grid{grid-template-columns:1fr;}.weather-strip{grid-template-columns:1fr 1fr;}}
@endsection

@section('content')
<div class="rekom-hero">
  <h1>Rekomendasi Tanam Cerdas</h1>
  <p>Cari lokasi Anda dan dapatkan rekomendasi tanaman berdasarkan cuaca terkini dengan AI.</p>
  <div class="search-bar-wrap">
    <input type="text" id="rekom-city" placeholder="Ketik nama kota Anda... (contoh: Wonogiri, Sragen)"/>
    <button class="btn btn-primary" onclick="fetchRekomendasi()">Cari →</button>
  </div>
</div>

<div class="rekom-results">
  <div id="rekom-loading" style="display:none;"><div class="spinner"></div><p style="text-align:center;color:var(--gray-500);">Menganalisis kondisi cuaca dengan AI...</p></div>
  <div id="rekom-error" style="display:none;background:#ffebee;border-radius:var(--radius);padding:1.25rem;color:#c62828;margin-bottom:1.5rem;font-size:.9rem;"></div>

  <div id="rekom-weather-strip" style="display:none;" class="weather-strip">
    <div><div style="font-size:2.5rem;" id="rk-emoji">☀️</div><div class="big" id="rk-temp">--°C</div><div class="lbl">Suhu</div></div>
    <div><div style="font-size:2.5rem;">💧</div><div class="big" id="rk-hum">--%</div><div class="lbl">Kelembapan</div></div>
    <div><div style="font-size:2.5rem;">💨</div><div class="big" id="rk-wind">--</div><div class="lbl">Angin</div></div>
    <div><div style="font-size:2.5rem;">📍</div><div class="big" style="font-size:1.1rem;margin-top:.3rem;" id="rk-city">--</div><div class="lbl">Lokasi</div></div>
  </div>

  <div id="rekom-container" style="display:none;">
    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
      <h2 style="font-family:var(--font-display);font-size:1.6rem;color:var(--green-dark);">Tanaman yang Direkomendasikan</h2>
      <span class="ai-badge">✨ Powered by Gemini AI</span>
    </div>
    <div class="rekom-grid" id="rekom-grid-items"></div>
    <div style="background:var(--green-mist);border-radius:16px;padding:1.5rem;margin-top:2rem;">
      <h3 style="font-size:1rem;font-weight:600;color:var(--green-dark);margin-bottom:.5rem;">⚠️ Catatan Penting</h3>
      <p style="font-size:.85rem;color:var(--gray-500);line-height:1.7;">Rekomendasi ini dibuat berdasarkan kondisi cuaca saat ini menggunakan AI. Perhatikan juga jenis tanah, sumber air, dan pengetahuan lokal sebelum memulai penanaman.</p>
    </div>
  </div>

  <div id="rekom-empty" style="text-align:center;padding:4rem 2rem;color:var(--gray-500);">
    <div style="font-size:3.5rem;margin-bottom:1rem;">🌾</div>
    <h3 style="font-family:var(--font-display);color:var(--green-dark);margin-bottom:.5rem;">Temukan Tanaman Terbaik untuk Lahan Anda</h3>
    <p>Masukkan nama kota atau wilayah Anda untuk mendapatkan rekomendasi tanam berdasarkan kondisi cuaca terkini.</p>
  </div>
</div>

<footer style="background:var(--gray-900);padding:2rem;text-align:center;color:rgba(255,255,255,.5);font-size:.82rem;">
  © {{ date('Y') }} Atamagri · <a href="{{ route('landing') }}" style="color:#7bbf7b;">Kembali ke Beranda</a>
</footer>
@endsection

@section('scripts')
<script>
document.getElementById('rekom-city').addEventListener('keydown', e => {
  if (e.key === 'Enter') fetchRekomendasi();
});

async function fetchRekomendasi() {
  const city = document.getElementById('rekom-city').value.trim();
  if (!city) { showToast('Masukkan nama kota terlebih dahulu', '⚠️'); return; }

  document.getElementById('rekom-empty').style.display = 'none';
  document.getElementById('rekom-container').style.display = 'none';
  document.getElementById('rekom-weather-strip').style.display = 'none';
  document.getElementById('rekom-error').style.display = 'none';
  document.getElementById('rekom-loading').style.display = 'block';

  try {
    const res = await fetch('{{ route("api.rekomendasi") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({ city }),
    });

    const json = await res.json();
    document.getElementById('rekom-loading').style.display = 'none';

    if (!json.success) {
      document.getElementById('rekom-error').textContent = '⚠️ ' + json.message;
      document.getElementById('rekom-error').style.display = 'block';
      return;
    }

    const w = json.weather;
    document.getElementById('rk-emoji').textContent = w.emoji;
    document.getElementById('rk-temp').textContent  = w.temp + '°C';
    document.getElementById('rk-hum').textContent   = w.humidity + '%';
    document.getElementById('rk-wind').textContent  = w.wind_speed + ' km/h';
    document.getElementById('rk-city').textContent  = w.name;
    document.getElementById('rekom-weather-strip').style.display = 'grid';

    buildRekomCards(json.rekomendasi, 'rekom-grid-items');
    document.getElementById('rekom-container').style.display = 'block';

  } catch (e) {
    document.getElementById('rekom-loading').style.display = 'none';
    document.getElementById('rekom-error').textContent = '⚠️ Gagal terhubung ke server.';
    document.getElementById('rekom-error').style.display = 'block';
  }
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
