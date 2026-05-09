@extends('layouts.app')
@section('title', 'Daftar')

@section('extra-styles')
.auth-page{min-height:100vh;display:grid;grid-template-columns:1fr 1fr;padding-top:64px;}
.auth-visual{background:linear-gradient(160deg,var(--green-dark) 0%,var(--green-mid) 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:4rem;position:relative;overflow:hidden;}
.auth-visual::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='1.5' fill='rgba(255,255,255,.06)'/%3E%3C/svg%3E") repeat;}
.auth-visual-content{position:relative;text-align:center;}
.auth-visual h2{font-family:var(--font-display);font-size:2.2rem;color:var(--white);margin-bottom:.75rem;line-height:1.25;}
.auth-visual p{color:rgba(255,255,255,.65);line-height:1.75;font-size:.95rem;}
.auth-visual-icon{width:80px;height:80px;background:rgba(255,255,255,.12);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 2rem;font-size:2.5rem;}
.auth-form-side{background:var(--white);display:flex;align-items:center;justify-content:center;padding:4rem 3rem;overflow-y:auto;}
.auth-form-box{width:100%;max-width:420px;}
.auth-form-box h3{font-family:var(--font-display);font-size:1.8rem;font-weight:700;color:var(--green-dark);margin-bottom:.4rem;}
.auth-form-box .sub{color:var(--gray-500);font-size:.9rem;margin-bottom:2rem;}
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:.85rem;font-weight:500;color:var(--gray-700);margin-bottom:.5rem;}
.form-group input{width:100%;padding:.7rem 1rem;border-radius:var(--radius);border:1.5px solid var(--gray-200);font-family:var(--font-body);font-size:.9rem;color:var(--gray-900);outline:none;transition:border-color .2s;}
.form-group input:focus{border-color:var(--green-light);}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.auth-switch{text-align:center;margin-top:1.25rem;font-size:.875rem;color:var(--gray-500);}
.auth-switch a{color:var(--green-mid);font-weight:600;text-decoration:none;}
.error-msg{background:#ffebee;color:#c62828;border-radius:8px;padding:.75rem 1rem;font-size:.85rem;margin-bottom:1rem;}
.field-error{color:#c62828;font-size:.78rem;margin-top:.3rem;}
@media(max-width:900px){.auth-visual{display:none;}.auth-page{grid-template-columns:1fr;}}
@endsection

@section('content')
<div class="auth-page">
  <div class="auth-visual">
    <div class="auth-visual-content">
      <div class="auth-visual-icon">🌱</div>
      <h2>Bergabung dengan<br>Atamagri</h2>
      <p>Daftarkan diri Anda dan nikmati fitur monitoring cuaca real-time serta rekomendasi tanam berbasis AI gratis.</p>
    </div>
  </div>
  <div class="auth-form-side">
    <div class="auth-form-box">
      <h3>Buat Akun Baru</h3>
      <p class="sub">Isi formulir di bawah untuk mulai bergabung.</p>

      @if($errors->any())
      <div class="error-msg">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Budi Santoso" required/>
          @error('name')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required/>
          @error('email')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>No. HP <span style="color:var(--gray-500);">(opsional)</span></label>
            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xxx"/>
          </div>
          <div class="form-group">
            <label>Kota/Lokasi <span style="color:var(--gray-500);">(opsional)</span></label>
            <input type="text" name="location" value="{{ old('location') }}" placeholder="Surakarta"/>
          </div>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="Minimal 8 karakter" required/>
          @error('password')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label>Konfirmasi Password</label>
          <input type="password" name="password_confirmation" placeholder="Ulangi password" required/>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.8rem;">Daftar Sekarang</button>
      </form>

      <div class="auth-switch">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
      </div>
      <div class="auth-switch" style="margin-top:.5rem;">
        <a href="{{ route('landing') }}">← Kembali ke Beranda</a>
      </div>
    </div>
  </div>
</div>
@endsection
