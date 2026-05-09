@extends('layouts.app')
@section('title', 'Testimoni')

@section('extra-styles')
.testi-hero{background:linear-gradient(160deg,var(--green-dark) 0%,var(--green-mid) 100%);padding:120px 2rem 60px;text-align:center;color:var(--white);}
.testi-hero h1{font-family:var(--font-display);font-size:2.5rem;font-weight:700;margin-bottom:.75rem;}
.testi-hero p{color:rgba(255,255,255,.7);}
.testi-list-card{background:var(--white);border-radius:16px;padding:1.75rem;border:1px solid var(--gray-200);margin-bottom:1.25rem;transition:box-shadow .2s;}
.testi-list-card:hover{box-shadow:var(--shadow-lg);}
.star-pick{font-size:1.8rem;cursor:pointer;transition:transform .15s;color:var(--gray-200);}
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:.85rem;font-weight:500;color:var(--gray-700);margin-bottom:.5rem;}
.form-group input,.form-group textarea{width:100%;padding:.7rem 1rem;border-radius:var(--radius);border:1.5px solid var(--gray-200);font-family:var(--font-body);font-size:.9rem;outline:none;transition:border-color .2s;resize:none;}
.form-group input:focus,.form-group textarea:focus{border-color:var(--green-light);}
@endsection

@section('content')
<div class="testi-hero">
  <h1>Testimoni Pengguna</h1>
  <p>Pengalaman nyata dari petani dan mitra yang telah menggunakan layanan Atamagri.</p>
  <span style="display:inline-block;margin-top:.75rem;background:rgba(255,255,255,.15);color:var(--white);padding:.35rem .9rem;border-radius:100px;font-size:.82rem;">{{ $testimonials->count() }} testimoni</span>
</div>

<div style="max-width:800px;margin:0 auto;padding:2rem 2rem 60px;">

  @if(session('success'))
  <div style="background:var(--green-pale);color:var(--green-mid);border-radius:10px;padding:1rem 1.25rem;margin-bottom:1.5rem;font-weight:500;">✅ {{ session('success') }}</div>
  @endif

  <!-- Form -->
  <div class="card" style="margin-bottom:2rem;">
    <div class="card-header"><h3>✍️ Tulis Testimoni</h3></div>
    <div class="card-body">
      <form method="POST" action="{{ route('testimoni.store') }}">
        @csrf
        <div style="margin-bottom:1.25rem;">
          <label style="font-size:.85rem;font-weight:500;color:var(--gray-700);display:block;margin-bottom:.5rem;">Rating</label>
          <div style="display:flex;gap:.35rem;" id="stars">
            @for($i=1;$i<=5;$i++)
            <span class="star-pick" onclick="setStar({{ $i }})" onmouseover="hoverStar({{ $i }})" onmouseout="resetStars()">★</span>
            @endfor
          </div>
          <input type="hidden" name="bintang" id="star-val" value="5"/>
          <div style="font-size:.8rem;color:var(--green-mid);margin-top:.35rem;" id="star-label">Luar Biasa! 🤩</div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
          <div class="form-group">
            <label>Nama <span style="color:#c62828;">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama Anda" required/>
            @error('nama')<div style="color:#c62828;font-size:.78rem;margin-top:.3rem;">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Peran / Pekerjaan</label>
            <input type="text" name="peran" value="{{ old('peran') }}" placeholder="Petani Sukoharjo"/>
          </div>
        </div>
        <div class="form-group">
          <label>Pesan <span style="color:#c62828;">*</span></label>
          <textarea name="pesan" rows="4" placeholder="Bagikan pengalaman Anda menggunakan Atamagri..." required>{{ old('pesan') }}</textarea>
          @error('pesan')<div style="color:#c62828;font-size:.78rem;margin-top:.3rem;">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Kirim Testimoni 🌾</button>
      </form>
    </div>
  </div>

  <!-- List -->
  @forelse($testimonials as $t)
  <div class="testi-list-card">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:.9rem;">
      <div style="display:flex;align-items:center;gap:.75rem;">
        <div style="width:42px;height:42px;border-radius:50%;background:var(--green-light);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;color:var(--green-dark);flex-shrink:0;">{{ $t->initials }}</div>
        <div>
          <div style="font-weight:700;color:var(--green-dark);font-size:.9rem;">{{ $t->nama }}</div>
          <div style="font-size:.76rem;color:var(--gray-500);">{{ $t->peran }}</div>
        </div>
      </div>
      <div style="color:#f9c74f;font-size:.9rem;">{{ str_repeat('★', $t->bintang) }}{{ str_repeat('☆', 5 - $t->bintang) }}</div>
    </div>
    <p style="font-size:.9rem;color:var(--gray-700);line-height:1.7;font-style:italic;">"{{ $t->pesan }}"</p>
    <div style="font-size:.75rem;color:var(--gray-500);margin-top:.75rem;">{{ $t->created_at->diffForHumans() }}</div>
  </div>
  @empty
  <div style="text-align:center;padding:3rem;color:var(--gray-500);">
    <div style="font-size:3rem;margin-bottom:1rem;">💬</div>
    <p>Belum ada testimoni. Jadilah yang pertama!</p>
  </div>
  @endforelse
</div>

<footer style="background:var(--gray-900);padding:2rem;text-align:center;color:rgba(255,255,255,.5);font-size:.82rem;">
  © {{ date('Y') }} Atamagri · <a href="{{ route('landing') }}" style="color:#7bbf7b;">Kembali ke Beranda</a>
</footer>
@endsection

@section('scripts')
<script>
const LABELS = ['','Sangat Kurang 😞','Kurang 😕','Cukup 😊','Bagus 😄','Luar Biasa! 🤩'];
let currentStar = 5;
let hovered = 0;

function setStar(v) {
  currentStar = v;
  document.getElementById('star-val').value = v;
  document.getElementById('star-label').textContent = LABELS[v];
  updateStars(v);
}
function hoverStar(v) { hovered = v; updateStars(v); }
function resetStars() { hovered = 0; updateStars(currentStar); }
function updateStars(v) {
  document.querySelectorAll('.star-pick').forEach((s,i) => {
    s.style.color = i < v ? '#f9c74f' : 'var(--gray-200)';
    s.style.transform = i < v ? 'scale(1.2)' : 'scale(1)';
  });
}
updateStars(5);
</script>
@endsection
