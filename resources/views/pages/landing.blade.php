@extends('layouts.app')
@section('title', 'Beranda')

@section('extra-styles')
/* ── HERO ── */
.hero{padding:140px 2rem 80px;max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;}
.hero-badge{display:inline-flex;align-items:center;gap:.5rem;background:var(--green-pale);color:var(--green-mid);padding:.35rem .9rem;border-radius:100px;font-size:.8rem;font-weight:600;margin-bottom:1.25rem;letter-spacing:.04em;}
.hero-badge span{width:7px;height:7px;background:var(--green-light);border-radius:50%;display:block;animation:pulse 2s infinite;}
.hero h1{font-family:var(--font-display);font-size:3.25rem;font-weight:700;line-height:1.12;color:var(--green-dark);letter-spacing:-.03em;margin-bottom:1.25rem;}
.hero h1 em{font-style:italic;color:var(--green-light);}
.hero p{color:var(--gray-500);line-height:1.75;font-size:1.05rem;margin-bottom:2rem;max-width:480px;}
.hero-actions{display:flex;gap:.75rem;flex-wrap:wrap;}
.hero-visual{position:relative;}
.hero-card{background:var(--white);border-radius:16px;padding:1.35rem;box-shadow:var(--shadow-lg);border:1px solid var(--gray-200);}
.hero-icon-bg{width:46px;height:46px;background:var(--green-pale);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;}
.hero-float{position:absolute;top:-16px;right:-16px;background:var(--green-dark);color:var(--white);border-radius:12px;padding:.75rem 1rem;box-shadow:var(--shadow-lg);font-size:.8rem;}
.hero-float strong{display:block;font-family:var(--font-display);font-size:1.2rem;}
/* PARTNERS */
.partners{background:var(--green-dark);padding:1.5rem 2rem;}
.partners-label{color:rgba(255,255,255,.5);font-size:.75rem;font-weight:600;letter-spacing:.08em;text-align:center;margin-bottom:.75rem;}
.partners-strip{display:flex;gap:3rem;align-items:center;justify-content:center;flex-wrap:wrap;}
.partners-strip span{color:rgba(255,255,255,.6);font-size:.85rem;font-weight:500;}
/* SECTIONS */
.section-wrap{padding:90px 2rem;max-width:1200px;margin:0 auto;}
.section-label{font-size:.75rem;font-weight:700;letter-spacing:.1em;color:var(--green-light);text-transform:uppercase;margin-bottom:.6rem;}
.section-title{font-family:var(--font-display);font-size:2.4rem;font-weight:700;color:var(--green-dark);line-height:1.18;letter-spacing:-.02em;margin-bottom:1rem;}
.section-sub{color:var(--gray-500);line-height:1.75;max-width:540px;}
/* ABOUT */
.about-inner{display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;}
.about-img-bg{width:100%;aspect-ratio:4/3;background:linear-gradient(135deg,var(--green-pale) 0%,var(--green-dark) 100%);border-radius:20px;display:flex;align-items:center;justify-content:center;}
.about-img-bg svg{width:80px;opacity:.3;fill:var(--white);}
.about-badge{position:absolute;bottom:-20px;right:-20px;background:var(--white);border-radius:14px;padding:1.25rem;box-shadow:var(--shadow-lg);border:1px solid var(--gray-200);}
.about-badge .num{font-family:var(--font-display);font-size:2rem;font-weight:700;color:var(--green-dark);}
.about-badge p{font-size:.8rem;color:var(--gray-500);}
.visi-misi{margin-top:2rem;display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.vm-box{background:var(--green-mist);border-radius:var(--radius);padding:1.25rem;}
.vm-box h4{font-weight:600;color:var(--green-dark);margin-bottom:.5rem;font-size:.9rem;}
.vm-box p{font-size:.85rem;color:var(--gray-500);line-height:1.65;}
/* ACHIEVEMENTS */
.achievements-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-top:3rem;}
.ach-card{background:var(--white);border-radius:16px;padding:1.75rem;border:1px solid var(--gray-200);transition:transform .25s,box-shadow .25s;}
.ach-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-lg);}
.ach-icon{width:44px;height:44px;background:var(--green-pale);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;font-size:1.4rem;}
.ach-card h4{font-weight:600;font-size:.95rem;color:var(--green-dark);line-height:1.4;}
.ach-card p{font-size:.8rem;color:var(--gray-500);margin-top:.4rem;}
/* TESTI */
.testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-top:3rem;}
.testi-card{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:16px;padding:1.75rem;}
.testi-quote{font-size:1.05rem;line-height:1.7;color:rgba(255,255,255,.85);margin-bottom:1.5rem;font-style:italic;}
.testi-author{display:flex;align-items:center;gap:.75rem;}
.testi-avatar{width:42px;height:42px;border-radius:50%;background:var(--green-light);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--green-dark);font-size:.9rem;}
.testi-name{font-weight:600;color:var(--white);font-size:.9rem;}
.testi-role{font-size:.78rem;color:rgba(255,255,255,.5);}
/* CTA */
.cta-strip{background:linear-gradient(135deg,var(--green-mid),var(--green-dark));padding:80px 2rem;text-align:center;}
.cta-strip h2{font-family:var(--font-display);font-size:2.5rem;color:var(--white);margin-bottom:1rem;}
.cta-strip p{color:rgba(255,255,255,.7);margin-bottom:2rem;font-size:1.05rem;}
/* FOOTER */
footer{background:var(--gray-900);padding:3rem 2rem 1.5rem;color:rgba(255,255,255,.6);}
.footer-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:2fr 1fr 1fr;gap:3rem;margin-bottom:2rem;}
.footer-col h4{font-weight:600;color:var(--white);margin-bottom:1rem;font-size:.9rem;}
.footer-col a{display:block;font-size:.85rem;color:rgba(255,255,255,.5);text-decoration:none;margin-bottom:.5rem;cursor:pointer;transition:color .2s;}
.footer-col a:hover{color:var(--accent);}
.footer-bottom{border-top:1px solid rgba(255,255,255,.08);padding-top:1.25rem;display:flex;justify-content:space-between;align-items:center;font-size:.8rem;}
@media(max-width:900px){
  .hero{grid-template-columns:1fr;padding:120px 1.5rem 60px;}
  .hero-visual{display:none;}
  .achievements-grid,.testi-grid{grid-template-columns:1fr 1fr;}
  .about-inner{grid-template-columns:1fr;}
  .footer-inner{grid-template-columns:1fr;}
}
@media(max-width:600px){.achievements-grid,.testi-grid{grid-template-columns:1fr;}}
@endsection

@section('content')

<div style="background:var(--off-white);">
  <div class="hero">
    <div class="hero-content">
      <div class="hero-badge"><span></span> Agriculture 5.0 Platform</div>
      <h1>Pertanian Modern <em>Dimulai</em> dari Sini</h1>
      <p>Atamagri menghadirkan teknologi IoT, monitoring cuaca real-time, dan rekomendasi tanam cerdas untuk membantu petani Indonesia bertumbuh lebih efisien dan mandiri.</p>
      <div class="hero-actions">
        <a href="{{ route('rekomendasi') }}" class="btn btn-primary btn-lg">🌾 Cek Rekomendasi</a>
        <a href="#about" class="btn btn-outline btn-lg">Pelajari Lebih Lanjut</a>
      </div>
    </div>
    <div class="hero-visual">
      <div class="hero-float"><strong>512+</strong> Petani Terdaftar</div>
      <div style="display:flex;flex-direction:column;gap:1rem;">
       
        <div class="hero-card" style="display:flex;align-items:flex-start;gap:1rem;">
          <div class="hero-icon-bg">🌤️</div>
          <div>
            <div style="font-family:var(--font-display);font-weight:700;font-size:1rem;color:var(--green-dark);margin-bottom:.3rem;">Monitoring Cuaca Real-Time</div>
            <div style="font-size:.83rem;color:var(--gray-500);line-height:1.6;">Pantau suhu, kelembapan, angin, dan tekanan udara di lokasi lahan Anda secara langsung setiap saat.</div>
          </div>
        </div>
     
        <div class="hero-card" style="display:flex;align-items:flex-start;gap:1rem;">
          <div class="hero-icon-bg">🌱</div>
          <div>
            <div style="font-family:var(--font-display);font-weight:700;font-size:1rem;color:var(--green-dark);margin-bottom:.3rem;">Rekomendasi Tanam Cerdas</div>
            <div style="font-size:.83rem;color:var(--gray-500);line-height:1.6;">Dapatkan saran tanaman terbaik berdasarkan kondisi cuaca dan musim di daerah Anda secara otomatis dengan AI.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="partners">
  <div class="partners-label">DEVELOPING PARTNER</div>
  <div class="partners-strip">
    <span>Universitas Sebelas Maret</span><span>BRIN</span><span>Kementan RI</span>
    <span>DIH UNS</span><span>TDC ITS</span><span>Semesta x Kemenkop</span><span>Krenova Surakarta</span>
  </div>
</div>

<div id="about" style="background:var(--white);padding:90px 0;">
  <div class="section-wrap" style="padding-top:0;padding-bottom:0;">
    <div class="about-inner">
      <div style="position:relative;">
        <div class="about-img-bg">
          <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14v-4H7l5-8v4h4l-5 8z"/></svg>
        </div>
        <div class="about-badge"><div class="num">6+</div><p>Penghargaan<br>Nasional</p></div>
      </div>
      <div>
        <div class="section-label">Tentang Kami</div>
        <h2 class="section-title">Mewujudkan Era Agriculture 5.0</h2>
        <p class="section-sub">Atamagri hadir untuk menjawab tantangan ketahanan pangan Indonesia dengan teknologi pertanian berbasis IoT yang dirancang sesuai kebutuhan petani masa kini.</p>
        <div class="visi-misi">
          <div class="vm-box"><h4>🎯 Visi</h4><p>Menjadi pionir revolusi pertanian 5.0 yang berkelanjutan, berdaya lingkungan, dan inklusif.</p></div>
          <div class="vm-box"><h4>🚀 Misi</h4><p>Menghadirkan inovasi teknologi 5.0 untuk meningkatkan produktivitas dan keberlanjutan pertanian.</p></div>
        </div>
        <div style="margin-top:1.5rem;">
          <a href="{{ route('register') }}" class="btn btn-primary">Bergabung Sekarang →</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="pencapaian" style="padding:90px 0;background:var(--off-white);">
  <div class="section-wrap" style="padding-top:0;padding-bottom:0;">
    <div style="text-align:center;margin-bottom:1rem;">
      <div class="section-label">Pencapaian</div>
      <h2 class="section-title">Penghargaan & Prestasi</h2>
      <p class="section-sub" style="margin:0 auto;">Beberapa pencapaian yang telah diraih Atamagri dalam perjalanan inovasi pertanian cerdas.</p>
    </div>
    <div class="achievements-grid">
      <div class="ach-card"><div class="ach-icon">🏆</div><h4>Juara 1 Krenova Surakarta 2024</h4><p>Meraih juara pertama dalam kompetisi inovasi tingkat kota Surakarta.</p></div>
      <div class="ach-card"><div class="ach-icon">🥈</div><h4>Pemenang Harapan Krenova Jawa Tengah 2024</h4><p>Pengakuan inovasi di tingkat provinsi Jawa Tengah.</p></div>
      <div class="ach-card"><div class="ach-icon">🌱</div><h4>Semesta x Kemenkop Incubation 2024</h4><p>Program inkubasi nasional bersama Kementerian Koperasi.</p></div>
      <div class="ach-card"><div class="ach-icon">🔬</div><h4>Funding Prototype DIH UNS 2023</h4><p>Dana pengembangan dari Direktorat Inovasi & Hilirisasi UNS.</p></div>
      <div class="ach-card"><div class="ach-icon">🥇</div><h4>Runner Up TDC ITS 2023</h4><p>Penghargaan dari Techno Development Centre ITS.</p></div>
      <div class="ach-card"><div class="ach-icon">💰</div><h4>Penerima Dana Riset BRIN 2022</h4><p>Mendapat dukungan riset dari Badan Riset Inovasi Nasional.</p></div>
    </div>
  </div>
</div>

<div style="background:var(--green-dark);padding:90px 0;">
  <div class="section-wrap" style="padding-top:0;padding-bottom:0;">
    <div style="text-align:center;margin-bottom:1rem;">
      <div class="section-label">Testimoni</div>
      <h2 class="section-title" style="color:var(--white);">Kata Mereka</h2>
      <p class="section-sub" style="color:rgba(255,255,255,.6);margin:0 auto;">Pengalaman nyata dari petani dan mitra yang telah menggunakan layanan Atamagri.</p>
    </div>
    <div class="testi-grid">
      @forelse($testimoniList as $t)
      <div class="testi-card">
        <p class="testi-quote">"{{ $t->pesan }}"</p>
        <div class="testi-author">
          <div class="testi-avatar">{{ $t->initials }}</div>
          <div><div class="testi-name">{{ $t->nama }}</div><div class="testi-role">{{ $t->peran }}</div></div>
        </div>
      </div>
      @empty
      <div class="testi-card"><p class="testi-quote">"Atamagri sangat membantu kegiatan pertanian saya sehari-hari."</p><div class="testi-author"><div class="testi-avatar">PT</div><div><div class="testi-name">Petani Indonesia</div><div class="testi-role">Pengguna Atamagri</div></div></div></div>
      @endforelse
    </div>
  </div>
</div>

<div class="cta-strip">
  <h2>Mulai Bertani Lebih Cerdas</h2>
  <p>Daftarkan diri Anda dan dapatkan akses ke monitoring cuaca dan rekomendasi tanam berbasis AI.</p>
  <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;">
    <a href="{{ route('register') }}" class="btn btn-lg" style="background:var(--white);color:var(--green-dark);">Daftar Gratis</a>
    <a href="{{ route('cuaca') }}" class="btn btn-lg btn-outline" style="border-color:rgba(255,255,255,.5);color:var(--white);">Cek Cuaca Sekarang</a>
  </div>
</div>

<footer>
  <div class="footer-inner">
    <div>
      <div style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;color:var(--white);">Atamagri</div>
      <p style="font-size:.875rem;line-height:1.7;margin-top:.75rem;">Platform pertanian cerdas berbasis IoT untuk mendukung ketahanan pangan Indonesia menuju Agriculture 5.0.</p>
      <div style="margin-top:1rem;font-size:.82rem;">📍 Merten, Tohudan, Kec. Colomadu, Karanganyar, Jawa Tengah<br/>📞 082114728871 · ✉️ atamagri@gmail.com</div>
    </div>
    <div class="footer-col">
      <h4>Platform</h4>
      <a href="{{ route('cuaca') }}">Cek Cuaca</a>
      <a href="{{ route('rekomendasi') }}">Rekomendasi Tanam</a>
      <a href="{{ route('login') }}">Login</a>
    </div>
    <div class="footer-col">
      <h4>Tentang</h4>
      <a href="#about">Tentang Kami</a>
      <a href="#pencapaian">Pencapaian</a>
      <a href="{{ route('testimoni') }}">Testimoni</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© {{ date('Y') }} Atamagri. Hak cipta dilindungi.</span>
    <span>🌾 Agriculture 5.0 Platform</span>
  </div>
</footer>
@endsection
