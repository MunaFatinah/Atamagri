@extends('layouts.app')
@section('title', 'Masuk')

@section('extra-styles')
body{background:var(--off-white);}
.auth-page{min-height:100vh;display:grid;grid-template-columns:1fr 1fr;padding-top:64px;}
.auth-visual{background:linear-gradient(160deg,var(--green-dark) 0%,var(--green-mid) 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:4rem;position:relative;overflow:hidden;}
.auth-visual::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='1.5' fill='rgba(255,255,255,.06)'/%3E%3C/svg%3E") repeat;}
.auth-visual-content{position:relative;text-align:center;}
.auth-visual h2{font-family:var(--font-display);font-size:2.2rem;color:var(--white);margin-bottom:.75rem;line-height:1.25;}
.auth-visual p{color:rgba(255,255,255,.65);line-height:1.75;font-size:.95rem;}
.auth-visual-icon{width:80px;height:80px;background:rgba(255,255,255,.12);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 2rem;font-size:2.5rem;}
.auth-form-side{background:var(--white);display:flex;align-items:center;justify-content:center;padding:4rem 3rem;}
.auth-form-box{width:100%;max-width:400px;}
.auth-form-box h3{font-family:var(--font-display);font-size:1.8rem;font-weight:700;color:var(--green-dark);margin-bottom:.4rem;}
.auth-form-box .sub{color:var(--gray-500);font-size:.9rem;margin-bottom:2rem;}
.auth-back{display:inline-flex;align-items:center;gap:.4rem;font-size:.85rem;color:var(--gray-500);text-decoration:none;margin-bottom:1.75rem;transition:color .2s;}
.auth-back:hover{color:var(--green-mid);}
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:.85rem;font-weight:500;color:var(--gray-700);margin-bottom:.5rem;}
.form-group input{width:100%;padding:.7rem 1rem;border-radius:var(--radius);border:1.5px solid var(--gray-200);font-family:var(--font-body);font-size:.9rem;color:var(--gray-900);outline:none;transition:border-color .2s;}
.form-group input:focus{border-color:var(--green-light);}
.auth-switch{text-align:center;margin-top:1.25rem;font-size:.875rem;color:var(--gray-500);}
.auth-switch a{color:var(--green-mid);font-weight:600;text-decoration:none;}
.auth-switch a:hover{text-decoration:underline;}
.error-msg{background:#ffebee;color:#c62828;border-radius:8px;padding:.75rem 1rem;font-size:.85rem;margin-bottom:1rem;}
.lupa-pass{font-size:.85rem;color:var(--green-mid);cursor:pointer;text-decoration:none;}
.lupa-pass:hover{text-decoration:underline;}
@media(max-width:900px){.auth-visual{display:none;}.auth-page{grid-template-columns:1fr;}}
@endsection

@section('content')
<div class="auth-page">

  {{-- Kiri: Visual --}}
  <div class="auth-visual">
    <div class="auth-visual-content">
      <div class="auth-visual-icon">🌱</div>
      <h2>Selamat Datang<br>di Atamagri</h2>
      <p>Solusi pertanian modern berbasis teknologi digital untuk petani Indonesia</p>
    </div>
  </div>

  {{-- Kanan: Form --}}
  <div class="auth-form-side">
    <div class="auth-form-box">

      <a href="{{ route('landing') }}" class="auth-back">← Kembali ke Beranda</a>

      <h3>Masuk ke Akun</h3>
      <p class="sub">Gunakan akun petani atau admin Anda</p>

      @if($errors->any())
      <div class="error-msg">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required/>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="Masukkan password" required/>
        </div>
        <div style="display:flex;align-items:center;justify-content:flex-end;margin-bottom:1.5rem;">
          <a href="#" class="lupa-pass">Lupa password?</a>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.8rem;">Masuk</button>
      </form>

      <div class="auth-switch">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
      </div>

    </div>
  </div>

</div>
@endsection