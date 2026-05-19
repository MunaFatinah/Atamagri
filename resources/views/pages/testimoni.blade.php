@extends('layouts.app')
@section('title', 'Testimoni')

@section('extra-styles')
.testi-hero{background:linear-gradient(160deg,var(--green-dark) 0%,var(--green-mid) 100%);padding:160px 2rem 100px;text-align:center;color:var(--white);}
.testi-hero h1{font-family:var(--font-display);font-size:2.5rem;font-weight:700;margin-bottom:.75rem;}
.testi-hero p{color:rgba(255,255,255,.7);}
.testi-stats-bar{display:flex;width:100%;align-items:center;justify-content:center;gap:64px;padding:5px 80px;background-color:#1a3a1a;}
.testi-stat-item{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;padding:10px;}
.testi-stat-num{font-family:var(--font-display);font-weight:700;color:#ffffff;font-size:28px;text-align:center;line-height:normal;}
.testi-stat-label{font-weight:400;color:rgba(255,255,255,.45);font-size:12px;text-align:center;line-height:normal;}
.testi-layout{display:flex;align-items:flex-start;justify-content:center;gap:32px;max-width:1200px;margin:0 auto;padding:40px 40px 60px;}
.testi-form-card{display:flex;flex-direction:column;width:471px;min-width:471px;align-items:flex-start;gap:0;padding:28px;background-color:#ffffff;border-radius:20px;border:1px solid #e8e8e4;overflow:hidden;flex-shrink:0;box-sizing:border-box;}
.testi-form-inner{display:flex;flex-direction:column;width:100%;align-items:flex-start;gap:4px;padding:0 0 16px 0;opacity:0.8;}
.testi-form-label{font-weight:400;color:#5cb85c;font-size:11px;letter-spacing:0;line-height:normal;}
.testi-form-title{font-family:var(--font-display);font-weight:700;color:#1a3a1a;font-size:24px;line-height:28.8px;}
.testi-form-sub{font-weight:400;color:#888884;font-size:13px;line-height:21.4px;margin-top:2px;}
.field-section{display:flex;flex-direction:column;width:100%;align-items:flex-start;gap:6px;padding:0 0 20px 0;}
.field-section-row{display:flex;width:100%;align-items:flex-start;gap:16px;padding:0 0 12px 0;}
.field-label{font-weight:700;color:#444440;font-size:11px;line-height:11px;display:block;margin-bottom:4px;}
.field-input{width:100%;padding:12px;border-radius:12px;border:1.5px solid #e8e8e4;font-size:11px;color:#888884;outline:none;transition:border-color .2s;resize:none;box-sizing:border-box;background:#ffffff;font-family:var(--font-body);}
.field-input:focus{border-color:#5cb85c;}
.field-input::placeholder{color:#888884;}
.field-half{flex:1;}
.star-row{display:flex;gap:.3rem;margin-bottom:2px;}
.star-pick{font-size:28px;cursor:pointer;transition:transform .15s,color .1s;color:#e8e8e4;line-height:28px;font-weight:700;}
.star-sublabel{font-size:12px;color:#888884;line-height:12px;margin-bottom:8px;}
.btn-kirim{display:flex;width:100%;height:50px;align-items:center;justify-content:center;background-color:#1a3a1a;border-radius:12px;border:none;cursor:pointer;transition:background .2s;margin-top:4px;}
.btn-kirim span{font-weight:700;color:#ffffff;font-size:14px;font-family:var(--font-body);}
.btn-kirim:hover{background:#2d5a2d;}
.testi-right{display:flex;flex-direction:column;flex:1;align-items:flex-start;gap:16px;}
.testi-right-title{font-family:var(--font-display);font-weight:700;color:#1a3a1a;font-size:20px;line-height:24px;height:49px;display:flex;align-items:center;}
.testi-scroll{width:100%;max-height:620px;overflow-y:auto;display:flex;flex-direction:column;gap:16px;padding-right:4px;}
.testi-scroll::-webkit-scrollbar{width:3px;}
.testi-scroll::-webkit-scrollbar-thumb{background:#e8e8e4;border-radius:3px;}
.testi-card-item{display:flex;flex-direction:column;width:100%;align-items:flex-start;gap:16px;padding:24px;background-color:#ffffff;border-radius:16px;border:1px solid #e8e8e4;box-sizing:border-box;}
.testi-card-item:hover{box-shadow:0 4px 20px rgba(0,0,0,.08);}
.testi-card-header{display:flex;align-items:center;justify-content:space-between;width:100%;gap:12px;}
.testi-card-user{display:flex;align-items:center;gap:12px;}
.testi-avatar{width:42px;height:42px;border-radius:21px;background-color:#5cb85c;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;color:#fff;flex-shrink:0;}
.testi-name{font-weight:700;color:#1a1a18;font-size:14px;line-height:16.8px;}
.testi-role{font-weight:400;color:#888884;font-size:12px;line-height:14.4px;}
.testi-stars{font-style:italic;color:#f9c74f;font-size:14px;line-height:23.8px;white-space:nowrap;}
.testi-pesan{font-style:italic;color:#444440;font-size:14px;line-height:23.8px;}
.testi-time{font-size:.72rem;color:#888884;margin-top:-.5rem;}
@media(max-width:900px){.testi-layout{flex-direction:column;align-items:center;padding:24px 20px 40px;}.testi-form-card{width:100%;min-width:unset;}.testi-right{width:100%;}.testi-stats-bar{gap:1.5rem;padding:20px;}}
@endsection

@section('content')

<div class="testi-hero">
  <h1>Kata Mereka tentang Atamagri</h1>
  <p>Pengalaman nyata dari petani dan mitra yang telah merasakan manfaat teknologi pertanian cerdas Atamagri.</p>
</div>

<div class="testi-stats-bar">
  <div class="testi-stat-item">
    <div class="testi-stat-num">512+</div>
    <div class="testi-stat-label">Petani Terdaftar</div>
  </div>
  <div class="testi-stat-item">
    <div class="testi-stat-num">4.9★</div>
    <div class="testi-stat-label">Rating Rata-rata</div>
  </div>
  <div class="testi-stat-item">
    <div class="testi-stat-num">{{ $testimonials->count() }}</div>
    <div class="testi-stat-label">Testimoni Masuk</div>
  </div>
</div>

@if(session('success'))
<div style="max-width:1200px;margin:1.5rem auto 0;padding:0 40px;">
  <div style="background:#f0faf0;color:#5cb85c;border-radius:10px;padding:1rem 1.25rem;font-weight:500;">✅ {{ session('success') }}</div>
</div>
@endif

<div class="testi-layout">

  <div class="testi-form-card">
    <div class="testi-form-inner">
      <div class="testi-form-label">BAGIKAN PENGALAMAN</div>
      <div class="testi-form-title">Ceritakan Pengalaman Bertani Anda</div>
      <p class="testi-form-sub">Testimoni Anda akan langsung muncul dan menginspirasi petani lain di seluruh Indonesia.</p>
    </div>

    <form method="POST" action="{{ route('testimoni.store') }}" style="width:100%;display:flex;flex-direction:column;gap:0;">
      @csrf

      <div class="field-section">
        <span class="field-label">PENILAIAN ANDA</span>
        <div class="star-row" id="stars">
          @for($i=1;$i<=5;$i++)
          <span class="star-pick" onclick="setStar({{ $i }})" onmouseover="hoverStar({{ $i }})" onmouseout="resetStars()">★</span>
          @endfor
        </div>
        <div class="star-sublabel" id="star-label">Pilih penilaian Anda</div>
        <input type="hidden" name="bintang" id="star-val" value="0"/>
      </div>

      <div class="field-section">
        <span class="field-label">PESAN</span>
        <textarea class="field-input" name="pesan" rows="4" placeholder="Ceritakan Pengalaman anda Menggunakan Atamagri..." required>{{ old('pesan') }}</textarea>
        @error('pesan')<div style="color:#c62828;font-size:.78rem;margin-top:.3rem;">{{ $message }}</div>@enderror
      </div>

      <div class="field-section-row">
        <div class="field-half">
          <span class="field-label">NAMA</span>
          <input class="field-input" type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama Anda" required/>
          @error('nama')<div style="color:#c62828;font-size:.78rem;margin-top:.3rem;">{{ $message }}</div>@enderror
        </div>
        <div class="field-half">
          <span class="field-label">PERAN/ASAL</span>
          <input class="field-input" type="text" name="peran" value="{{ old('peran') }}" placeholder="Petani Sukoharjo"/>
        </div>
      </div>

      <button type="submit" class="btn-kirim">
        <span>Kirim testimoni Saya</span>
      </button>
    </form>
  </div>

  <div class="testi-right">
    <div class="testi-right-title">Semua Testimoni</div>
    <div class="testi-scroll">
      @forelse($testimonials as $t)
      <div class="testi-card-item">
        <div class="testi-card-header">
          <div class="testi-card-user">
            <div class="testi-avatar">{{ $t->initials }}</div>
            <div>
              <div class="testi-name">{{ $t->nama }}</div>
              <div class="testi-role">{{ $t->peran }}</div>
            </div>
          </div>
          <div class="testi-stars">{{ str_repeat('★', $t->bintang) }}{{ str_repeat('☆', 5 - $t->bintang) }}</div>
        </div>
        <p class="testi-pesan">"{{ $t->pesan }}"</p>
        <div class="testi-time">{{ $t->created_at->diffForHumans() }}</div>
      </div>
      @empty
      <div style="text-align:center;padding:3rem;color:#888884;">
        <div style="font-size:3rem;margin-bottom:1rem;">💬</div>
        <p>Belum ada testimoni. Jadilah yang pertama!</p>
      </div>
      @endforelse
    </div>
  </div>

</div>

<footer style="width:100%;height:57px;background-color:#1a1a18;display:flex;align-items:center;justify-content:center;">
  <span style="font-family:var(--font-body);font-weight:400;color:#ffffff;font-size:17px;text-align:center;letter-spacing:0;line-height:normal;">© {{ date('Y') }} Atamagri</span>
</footer>
@endsection

@section('scripts')
<script>
const LABELS = ['Pilih penilaian Anda','Sangat Kurang','Kurang','Cukup','Bagus','Luar Biasa!'];
let currentStar = 0;

function setStar(v) {
  currentStar = v;
  document.getElementById('star-val').value = v;
  document.getElementById('star-label').textContent = LABELS[v];
  updateStars(v);
}
function hoverStar(v) { updateStars(v); }
function resetStars() { updateStars(currentStar); }
function updateStars(v) {
  document.querySelectorAll('.star-pick').forEach((s,i) => {
    s.style.color = i < v ? '#f9c74f' : '#e8e8e4';
    s.style.transform = i < v ? 'scale(1.1)' : 'scale(1)';
  });
}
updateStars(0);
</script>
@endsection