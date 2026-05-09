<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Atamagri') — Pertanian Cerdas 5.0</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,600;0,9..144,700;1,9..144,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<style>
:root{
  --green-dark:#1a3a1a; --green-mid:#2d6a2d; --green:#3a8a3a;
  --green-light:#5cb85c; --green-pale:#e8f5e8; --green-mist:#f0f7f0;
  --accent:#7bbf7b; --soil:#8b6914; --gold:#d4a017;
  --white:#ffffff; --off-white:#fafaf8;
  --gray-100:#f4f4f2; --gray-200:#e8e8e4; --gray-500:#888884;
  --gray-700:#444440; --gray-900:#1a1a18;
  --font-display:'Fraunces',serif; --font-body:'DM Sans',sans-serif;
  --radius:12px; --shadow:0 4px 24px rgba(26,58,26,.10);
  --shadow-lg:0 12px 48px rgba(26,58,26,.16);
}
*{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
body{font-family:var(--font-body);color:var(--gray-900);background:var(--off-white);overflow-x:hidden;}
::-webkit-scrollbar{width:6px;}
::-webkit-scrollbar-track{background:var(--green-mist);}
::-webkit-scrollbar-thumb{background:var(--green-light);border-radius:4px;}
nav{position:fixed;top:0;left:0;right:0;z-index:900;background:rgba(255,255,255,.92);backdrop-filter:blur(16px);border-bottom:1px solid var(--gray-200);padding:0 2rem;display:flex;align-items:center;justify-content:space-between;height:64px;}
.nav-logo{display:flex;align-items:center;gap:.6rem;text-decoration:none;}
.nav-logo-mark{width:34px;height:34px;background:var(--green-dark);border-radius:8px;display:flex;align-items:center;justify-content:center;}
.nav-logo-mark svg{width:20px;height:20px;fill:var(--white);}
.nav-logo-text{font-family:var(--font-display);font-weight:700;font-size:1.25rem;color:var(--green-dark);letter-spacing:-.02em;}
.nav-links{display:flex;align-items:center;gap:.25rem;}
.nav-links a{font-size:.875rem;font-weight:500;color:var(--gray-700);padding:.45rem .85rem;border-radius:8px;cursor:pointer;transition:color .2s,background .2s;text-decoration:none;}
.nav-links a:hover{color:var(--green-dark);background:var(--green-pale);}
.nav-links a.active{color:var(--green-mid);background:var(--green-pale);}
.nav-cta{display:flex;align-items:center;gap:.5rem;}
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.2rem;border-radius:var(--radius);font-family:var(--font-body);font-size:.875rem;font-weight:600;cursor:pointer;border:none;transition:all .2s;text-decoration:none;}
.btn-primary{background:var(--green-dark);color:var(--white);}
.btn-primary:hover{background:var(--green-mid);transform:translateY(-1px);}
.btn-outline{background:transparent;color:var(--green-dark);border:1.5px solid var(--green-dark);}
.btn-outline:hover{background:var(--green-pale);}
.btn-sm{padding:.4rem .9rem;font-size:.8rem;}
.btn-lg{padding:.75rem 1.8rem;font-size:1rem;}
.btn-danger{background:#e53935;color:#fff;}
.btn-danger:hover{background:#c62828;}
.toast{position:fixed;bottom:2rem;right:2rem;z-index:2000;background:var(--green-dark);color:var(--white);padding:1rem 1.5rem;border-radius:var(--radius);box-shadow:var(--shadow-lg);display:none;animation:slideUp .3s ease;font-size:.9rem;}
.toast.show{display:flex;align-items:center;gap:.5rem;}
@keyframes slideUp{from{transform:translateY(20px);opacity:0;}to{transform:translateY(0);opacity:1;}}
@keyframes spin{to{transform:rotate(360deg);}}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.5;transform:scale(1.4);}}
.spinner{width:36px;height:36px;border:3px solid var(--gray-200);border-top-color:var(--green-mid);border-radius:50%;animation:spin .8s linear infinite;margin:2rem auto;}
@media(max-width:900px){nav .nav-links{display:none;}}
@yield('extra-styles')
</style>
@yield('head')
</head>
<body>

@unless(isset($hideNav) && $hideNav)
<nav>
  <a class="nav-logo" href="{{ route('landing') }}">
    <div class="nav-logo-mark">
      <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14v-4H7l5-8v4h4l-5 8z"/></svg>
    </div>
    <span class="nav-logo-text">Atamagri</span>
  </a>
  <div class="nav-links">
    <a href="{{ route('landing') }}#about" class="{{ request()->is('/') ? 'active' : '' }}">Tentang</a>
    <a href="{{ route('landing') }}#pencapaian">Pencapaian</a>
    <a href="{{ route('cuaca') }}" class="{{ request()->is('cuaca') ? 'active' : '' }}">Cuaca</a>
    <a href="{{ route('rekomendasi') }}" class="{{ request()->is('rekomendasi') ? 'active' : '' }}">Rekomendasi</a>
    <a href="{{ route('testimoni') }}" class="{{ request()->is('testimoni') ? 'active' : '' }}">Testimoni</a>
  </div>
  <div class="nav-cta">
    @auth
      @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.index') }}" class="btn btn-primary btn-sm">Dashboard Admin</a>
      @else
        <a href="{{ route('dashboard.index') }}" class="btn btn-primary btn-sm">Dashboard</a>
      @endif
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button class="btn btn-outline btn-sm" type="submit">Keluar</button>
      </form>
    @else
      <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Masuk</a>
      <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
    @endauth
  </div>
</nav>
@endunless

@yield('content')

<div class="toast" id="toast">
  <span>✅</span>
  <span id="toast-msg"></span>
</div>

<script>
function showToast(msg, icon='✅') {
  const t = document.getElementById('toast');
  document.getElementById('toast-msg').textContent = msg;
  t.querySelector('span').textContent = icon;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3500);
}

// Auto-show flash messages
@if(session('success'))
document.addEventListener('DOMContentLoaded', () => showToast('{{ session('success') }}'));
@endif
@if(session('error'))
document.addEventListener('DOMContentLoaded', () => showToast('{{ session('error') }}', '❌'));
@endif
</script>

@yield('scripts')
</body>
</html>
