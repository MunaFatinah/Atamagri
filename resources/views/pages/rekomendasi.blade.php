@extends('layouts.app')
@section('title', 'Rekomendasi Tanam')

@section('extra-styles')
.rekom-hero{background:linear-gradient(160deg,var(--green-dark) 0%,var(--green-mid) 100%);padding:120px 2rem 60px;text-align:center;color:var(--white);}
.rekom-hero h1{font-family:var(--font-display);font-size:2.5rem;font-weight:700;margin-bottom:.75rem;}
.rekom-hero p{color:rgba(255,255,255,.7);margin-bottom:2rem;}
.search-bar-wrap{display:flex;gap:.75rem;max-width:560px;margin:0 auto;}
.search-bar-wrap input{flex:1;padding:.8rem 1.2rem;border-radius:var(--radius);border:none;font-family:var(--font-body);font-size:.95rem;outline:none;}
.rekom-results{max-width:1100px;margin:0 auto;padding:2rem 2rem 60px;}

/* Weather Card — Figma */
.weather-card{background:#fff;border-radius:20px;border:1px solid #e8e8e4;padding:47px 80px 48px 51px;margin-bottom:2rem;display:flex;align-items:center;gap:80px;flex-wrap:wrap;}
.weather-main{min-width:180px;display:flex;flex-direction:column;align-items:center;}
.weather-location{font-family:"DM Sans",var(--font-body),Helvetica;font-weight:400;color:#888884;font-size:19px;text-align:center;margin:0 0 4px;white-space:nowrap;}
.weather-temp-big{font-family:var(--font-display),Helvetica;font-weight:700;color:#1a3a1a;font-size:80px;text-align:center;line-height:normal;margin:0 0 2px;}
.weather-desc-lbl{font-family:"DM Sans",var(--font-body),Helvetica;font-weight:400;color:#444440;font-size:16px;text-align:center;margin:0;}
.weather-stats{display:flex;gap:64px;flex-wrap:wrap;align-items:center;justify-content:center;}
.weather-stat{display:flex;flex-direction:column;align-items:center;gap:20px;}
.weather-stat-emoji{font-size:52px;line-height:normal;display:flex;align-items:center;justify-content:center;}
.weather-stat-info{display:flex;flex-direction:column;align-items:center;gap:5px;}
.weather-stat-val{font-family:"DM Sans",var(--font-body),Helvetica;font-weight:700;color:#000;font-size:20px;text-align:center;white-space:nowrap;}
.weather-stat-lbl{font-family:"DM Sans",var(--font-body),Helvetica;font-weight:400;color:#888884;font-size:12px;text-align:center;white-space:nowrap;}

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
.chat-section{background:var(--white);border-radius:20px;box-shadow:var(--shadow-lg);margin-top:2rem;overflow:hidden;}
.chat-header{background:var(--green-dark);padding:1rem 1.5rem;display:flex;align-items:center;gap:.75rem;}
.chat-avatar{width:36px;height:36px;background:var(--green-light);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;}
.chat-header-info{color:var(--white);}
.chat-header-info strong{display:block;font-size:.95rem;}
.chat-header-info span{font-size:.75rem;opacity:.7;}
.chat-messages{padding:1.25rem;display:flex;flex-direction:column;gap:1rem;max-height:420px;overflow-y:auto;}
.chat-bubble{max-width:80%;padding:.75rem 1rem;border-radius:16px;font-size:.875rem;line-height:1.6;}
.chat-bubble.ai{background:var(--green-mist);color:var(--gray-900);border-bottom-left-radius:4px;align-self:flex-start;}
.chat-bubble.user{background:var(--green-dark);color:var(--white);border-bottom-right-radius:4px;align-self:flex-end;}
.chat-bubble.typing{background:var(--green-mist);align-self:flex-start;padding:.75rem 1.2rem;}
.typing-dot{display:inline-block;width:7px;height:7px;background:var(--green-mid);border-radius:50%;animation:bounce .9s ease infinite;}
.typing-dot:nth-child(2){animation-delay:.15s;}
.typing-dot:nth-child(3){animation-delay:.3s;}
@keyframes bounce{0%,80%,100%{transform:translateY(0);}40%{transform:translateY(-6px);}}
.chat-input-row{display:flex;gap:.6rem;padding:1rem 1.25rem;border-top:1px solid var(--gray-200);}
.chat-input-row input{flex:1;padding:.65rem 1rem;border:1.5px solid var(--gray-200);border-radius:var(--radius);font-family:var(--font-body);font-size:.875rem;outline:none;transition:border .2s;}
.chat-input-row input:focus{border-color:var(--green-mid);}
.chat-quick{display:flex;flex-wrap:wrap;gap:.5rem;padding:.5rem 1.25rem 1rem;}
.quick-btn{background:var(--green-pale);color:var(--green-mid);border:none;border-radius:100px;padding:.3rem .85rem;font-size:.78rem;font-weight:500;cursor:pointer;font-family:var(--font-body);transition:background .2s;}
.quick-btn:hover{background:var(--green-light);color:var(--white);}
@media(max-width:700px){.rekom-grid{grid-template-columns:1fr;}.weather-card{gap:2rem;padding:28px 24px;}.weather-stats{gap:28px;}.weather-temp-big{font-size:56px;}.weather-stat-emoji{font-size:36px;}}
@endsection

@section('content')
<div class="rekom-hero">
  <h1>Rekomendasi Tanam Cerdas</h1>
  <p>Cari lokasi Anda dan dapatkan rekomendasi tanaman berdasarkan cuaca terkini dengan AI.</p>
  <div class="search-bar-wrap">
    <input type="text" id="rekom-city" placeholder="Ketik nama kota Anda... (contoh: Wonogiri, Sragen)"/>
    <button class="btn btn-primary" onclick="fetchRekomendasi()">Cari</button>
  </div>
</div>

<div class="rekom-results">
  <div id="rekom-loading" style="display:none;"><div class="spinner"></div><p style="text-align:center;color:var(--gray-500);">Menganalisis kondisi cuaca dengan AI...</p></div>
  <div id="rekom-error" style="display:none;background:#ffebee;border-radius:var(--radius);padding:1.25rem;color:#c62828;margin-bottom:1.5rem;font-size:.9rem;"></div>

  {{-- Weather Card Figma --}}
  <div id="rekom-weather-strip" style="display:none;" class="weather-card">
    <div class="weather-main">
      <p class="weather-location" id="rk-city">--</p>
      <p class="weather-temp-big" id="rk-temp">--°C</p>
      <p class="weather-desc-lbl" id="rk-desc">--</p>
    </div>
    <div class="weather-stats">
      <div class="weather-stat">
        <span class="weather-stat-emoji" id="rk-emoji">☀️</span>
        <div class="weather-stat-info">
          <span class="weather-stat-val" id="rk-temp2">--°C</span>
          <span class="weather-stat-lbl">Suhu</span>
        </div>
      </div>
      <div class="weather-stat">
        <span class="weather-stat-emoji">💧</span>
        <div class="weather-stat-info">
          <span class="weather-stat-val" id="rk-hum">--%</span>
          <span class="weather-stat-lbl">Kelembapan</span>
        </div>
      </div>
      <div class="weather-stat">
        <span class="weather-stat-emoji">💨</span>
        <div class="weather-stat-info">
          <span class="weather-stat-val" id="rk-wind">--</span>
          <span class="weather-stat-lbl">Angin</span>
        </div>
      </div>
      <div class="weather-stat">
        <span class="weather-stat-emoji">🔵</span>
        <div class="weather-stat-info">
          <span class="weather-stat-val" id="rk-pressure">--</span>
          <span class="weather-stat-lbl">Tekanan</span>
        </div>
      </div>
    </div>
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

    <div id="chat-section" class="chat-section">
      <div class="chat-header">
        <div class="chat-avatar">🌾</div>
        <div class="chat-header-info">
          <strong>Pak Tani AI</strong>
          <span>Konsultan pertanian berbasis cuaca lokal Anda</span>
        </div>
      </div>
      <div class="chat-messages" id="chat-messages"></div>
      <div class="chat-quick" id="chat-quick">
        <button class="quick-btn" onclick="sendQuick(this)">Kapan waktu tanam terbaik?</button>
        <button class="quick-btn" onclick="sendQuick(this)">Pupuk apa yang cocok?</button>
        <button class="quick-btn" onclick="sendQuick(this)">Hama apa yang perlu diwaspadai?</button>
        <button class="quick-btn" onclick="sendQuick(this)">Berapa lama masa panen?</button>
      </div>
      <div class="chat-input-row">
        <input type="text" id="chat-input" placeholder="Tanya soal pertanian, cuaca, atau tanaman..."/>
        <button class="btn btn-primary" onclick="sendChat()">Kirim</button>
      </div>
    </div>
  </div>

  <div id="rekom-empty" style="text-align:center;padding:4rem 2rem;color:var(--gray-500);">
    <div style="font-size:3.5rem;margin-bottom:1rem;">🌾</div>
    <h3 style="font-family:var(--font-display);color:var(--green-dark);margin-bottom:.5rem;">Temukan Tanaman Terbaik untuk Lahan Anda</h3>
    <p>Masukkan nama kota atau wilayah Anda untuk mendapatkan rekomendasi tanam berdasarkan kondisi cuaca terkini.</p>
  </div>
</div>

<footer style="width:100%;height:57px;background-color:#1a1a18;display:flex;align-items:center;justify-content:center;">
  <span style="font-family:var(--font-body);font-weight:400;color:#ffffff;font-size:17px;text-align:center;">© {{ date('Y') }} Atamagri</span>
</footer>
@endsection

@section('scripts')
<script>
let currentWeather = null;
let currentCity    = null;
let chatHistory    = [];
let typingCounter  = 0;

document.getElementById('rekom-city').addEventListener('keydown', e => {
  if (e.key === 'Enter') fetchRekomendasi();
});

document.addEventListener('DOMContentLoaded', () => {
  const ci = document.getElementById('chat-input');
  if (ci) ci.addEventListener('keydown', e => { if (e.key === 'Enter') sendChat(); });
});

async function fetchRekomendasi() {
  const city = document.getElementById('rekom-city').value.trim();
  if (!city) { showToast('Masukkan nama kota terlebih dahulu', '⚠️'); return; }

  document.getElementById('rekom-empty').style.display         = 'none';
  document.getElementById('rekom-container').style.display     = 'none';
  document.getElementById('rekom-weather-strip').style.display = 'none';
  document.getElementById('rekom-error').style.display         = 'none';
  document.getElementById('rekom-loading').style.display       = 'block';
  chatHistory = [];

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
      document.getElementById('rekom-error').textContent    = '⚠️ ' + json.message;
      document.getElementById('rekom-error').style.display = 'block';
      return;
    }

    const w = json.weather;
    currentWeather = w;
    currentCity    = w.name;

    document.getElementById('rk-city').textContent     = w.name + ', ' + (w.country || 'ID');
    document.getElementById('rk-temp').textContent     = w.temp + '°C';
    document.getElementById('rk-desc').textContent     = w.description || '';
    document.getElementById('rk-emoji').textContent    = w.emoji;
    document.getElementById('rk-temp2').textContent    = w.temp + '°C';
    document.getElementById('rk-hum').textContent      = w.humidity + '%';
    document.getElementById('rk-wind').textContent     = w.wind_speed + ' km/h';
    document.getElementById('rk-pressure').textContent = w.pressure + ' hPa';
    document.getElementById('rekom-weather-strip').style.display = 'flex';

    buildRekomCards(json.rekomendasi, 'rekom-grid-items');
    document.getElementById('rekom-container').style.display = 'block';

    initChat(json.rekomendasi);

  } catch (e) {
    document.getElementById('rekom-loading').style.display = 'none';
    document.getElementById('rekom-error').textContent     = '⚠️ Gagal terhubung ke server.';
    document.getElementById('rekom-error').style.display  = 'block';
  }
}

function initChat(crops) {
  const d        = currentWeather;
  const topCrop  = crops[0]?.nama || 'tanaman pilihan';
  const topScore = crops[0]?.skor || '-';
  const cropList = crops.slice(0, 3).map(c => c.nama).join(', ');

  const opening = `Halo! Saya sudah menganalisis cuaca di <strong>${currentCity}</strong> — suhu ${d.temp}°C, kelembapan ${d.humidity}%, angin ${d.wind_speed} km/h.<br><br>Top rekomendasi: <strong>${topCrop}</strong> (skor ${topScore}%), diikuti ${cropList}.<br><br>Ada yang ingin ditanyakan? Misalnya cara tanam, pupuk, hama, atau jadwal tanam terbaik.`;

  chatHistory = [
    { role: 'user',  content: buildSystemContext() },
    { role: 'model', content: opening.replace(/<[^>]+>/g, '') },
  ];

  document.getElementById('chat-messages').innerHTML = '';
  document.getElementById('chat-quick').style.display = 'flex';
  appendBubble('ai', opening);
}

async function sendChat() {
  const input = document.getElementById('chat-input');
  const msg   = input.value.trim();
  if (!msg || !currentWeather) return;
  input.value = '';

  appendBubble('user', msg);
  document.getElementById('chat-quick').style.display = 'none';
  chatHistory.push({ role: 'user', content: msg });

  const typingId = appendTyping();

  try {
    const res = await fetch('{{ route("api.chat") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({ history: chatHistory, weather: currentWeather, city: currentCity }),
    });

    const json = await res.json();
    removeTyping(typingId);

    const reply = json.reply || 'Maaf, saya tidak bisa menjawab saat ini.';
    chatHistory.push({ role: 'model', content: reply });
    appendBubble('ai', reply.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>'));

  } catch (e) {
    removeTyping(typingId);
    appendBubble('ai', 'Maaf, gagal terhubung ke AI. Coba lagi.');
  }
}

function sendQuick(btn) {
  document.getElementById('chat-input').value = btn.textContent;
  sendChat();
}

function buildSystemContext() {
  const d = currentWeather;
  return `Kamu adalah Pak Tani AI, konsultan pertanian Indonesia yang ramah dan praktis. Kamu sedang membantu petani di ${currentCity}. Data cuaca saat ini: suhu ${d.temp}°C (terasa ${d.feels_like}°C), kelembapan ${d.humidity}%, angin ${d.wind_speed} km/h, tekanan ${d.pressure} hPa, kondisi: ${d.description}. Jawab pertanyaan seputar pertanian dengan singkat, praktis, dan relevan dengan kondisi cuaca lokal ini. Gunakan bahasa Indonesia yang ramah.`;
}

function appendBubble(type, html) {
  const box = document.getElementById('chat-messages');
  const div = document.createElement('div');
  div.className = 'chat-bubble ' + type;
  div.innerHTML = html;
  box.appendChild(div);
  box.scrollTop = box.scrollHeight;
}

function appendTyping() {
  const id  = 'typing-' + (++typingCounter);
  const box = document.getElementById('chat-messages');
  const div = document.createElement('div');
  div.className = 'chat-bubble typing';
  div.id        = id;
  div.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
  box.appendChild(div);
  box.scrollTop = box.scrollHeight;
  return id;
}

function removeTyping(id) { document.getElementById(id)?.remove(); }

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