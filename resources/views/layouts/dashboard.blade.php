<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — Atamagri</title>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,600;0,9..144,700;1,9..144,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<style>
:root{--green-dark:#1a3a1a;--green-mid:#2d6a2d;--green:#3a8a3a;--green-light:#5cb85c;--green-pale:#e8f5e8;--green-mist:#f0f7f0;--accent:#7bbf7b;--white:#ffffff;--off-white:#fafaf8;--gray-100:#f4f4f2;--gray-200:#e8e8e4;--gray-500:#888884;--gray-700:#444440;--gray-900:#1a1a18;--font-display:'Fraunces',serif;--font-body:'DM Sans',sans-serif;--radius:12px;--shadow:0 4px 24px rgba(26,58,26,.10);--shadow-lg:0 12px 48px rgba(26,58,26,.16);}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--font-body);color:var(--gray-900);background:var(--off-white);}
.dashboard-layout{display:flex;min-height:100vh;}
.sidebar{width:240px;background:var(--green-dark);flex-shrink:0;display:flex;flex-direction:column;padding:1.5rem 1rem;position:fixed;top:0;bottom:0;left:0;z-index:800;overflow-y:auto;}
.sidebar-logo{display:flex;align-items:center;gap:.6rem;margin-bottom:2rem;padding:.25rem .5rem;text-decoration:none;}
.sidebar-logo-mark{width:32px;height:32px;background:rgba(255,255,255,.15);border-radius:8px;display:flex;align-items:center;justify-content:center;}
.sidebar-logo-mark svg{fill:var(--white);width:18px;}
.sidebar-logo-text{font-family:var(--font-display);font-weight:700;font-size:1.1rem;color:var(--white);}
.sidebar-section{font-size:.68rem;font-weight:700;letter-spacing:.1em;color:rgba(255,255,255,.35);padding:.25rem .5rem;margin-bottom:.4rem;text-transform:uppercase;}
.sidebar-item{display:flex;align-items:center;gap:.6rem;padding:.65rem .85rem;border-radius:10px;cursor:pointer;color:rgba(255,255,255,.65);font-size:.88rem;font-weight:500;transition:all .2s;text-decoration:none;margin-bottom:.15rem;}
.sidebar-item:hover{background:rgba(255,255,255,.1);color:var(--white);}
.sidebar-item.active{background:rgba(255,255,255,.15);color:var(--white);}
.sidebar-item svg{width:18px;height:18px;flex-shrink:0;}
.sidebar-spacer{flex:1;}
.sidebar-user{display:flex;align-items:center;gap:.75rem;padding:.75rem;background:rgba(255,255,255,.08);border-radius:10px;}
.sidebar-user-avatar{width:36px;height:36px;background:var(--green-light);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--green-dark);font-size:.85rem;flex-shrink:0;}
.sidebar-user-name{font-size:.85rem;font-weight:600;color:var(--white);}
.sidebar-user-role{font-size:.72rem;color:rgba(255,255,255,.5);}
.main-content{margin-left:240px;flex:1;background:var(--off-white);}
.main-header{background:var(--white);border-bottom:1px solid var(--gray-200);padding:1rem 2rem;display:flex;align-items:center;justify-content:space-between;}
.main-header h1{font-family:var(--font-display);font-size:1.4rem;font-weight:700;color:var(--green-dark);}
.main-header p{font-size:.85rem;color:var(--gray-500);}
.main-body{padding:2rem;}
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.2rem;border-radius:var(--radius);font-family:var(--font-body);font-size:.875rem;font-weight:600;cursor:pointer;border:none;transition:all .2s;text-decoration:none;}
.btn-primary{background:var(--green-dark);color:var(--white);}
.btn-primary:hover{background:var(--green-mid);}
.btn-outline{background:transparent;color:var(--green-dark);border:1.5px solid var(--green-dark);}
.btn-outline:hover{background:var(--green-pale);}
.btn-sm{padding:.4rem .9rem;font-size:.8rem;}
.btn-danger{background:#e53935;color:#fff;}
.btn-danger:hover{background:#c62828;}
.card{background:var(--white);border-radius:16px;border:1px solid var(--gray-200);overflow:hidden;}
.card-header{padding:1.25rem 1.5rem;border-bottom:1px solid var(--gray-200);display:flex;align-items:center;justify-content:space-between;}
.card-header h3{font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--green-dark);}
.card-body{padding:1.5rem;}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:2rem;}
.stat-card{background:var(--white);border-radius:var(--radius);padding:1.5rem;border:1px solid var(--gray-200);display:flex;align-items:flex-start;gap:1rem;}
.stat-icon{width:46px;height:46px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;}
.stat-icon.green{background:var(--green-pale);color:var(--green-mid);}
.stat-icon.blue{background:#e3f2fd;color:#1976d2;}
.stat-icon.orange{background:#fff3e0;color:#f57c00;}
.stat-val{font-family:var(--font-display);font-size:1.8rem;font-weight:700;color:var(--green-dark);line-height:1;}
.stat-lbl{font-size:.8rem;color:var(--gray-500);margin-top:.25rem;}
.toast{position:fixed;bottom:2rem;right:2rem;z-index:2000;background:var(--green-dark);color:var(--white);padding:1rem 1.5rem;border-radius:var(--radius);box-shadow:var(--shadow-lg);display:none;animation:slideUp .3s ease;font-size:.9rem;}
.toast.show{display:flex;align-items:center;gap:.5rem;}
@keyframes slideUp{from{transform:translateY(20px);opacity:0;}to{transform:translateY(0);opacity:1;}}
@keyframes spin{to{transform:rotate(360deg);}}
.spinner{width:36px;height:36px;border:3px solid var(--gray-200);border-top-color:var(--green-mid);border-radius:50%;animation:spin .8s linear infinite;margin:2rem auto;}
@media(max-width:900px){.sidebar{width:60px;}.sidebar-logo-text,.sidebar-item span,.sidebar-section,.sidebar-user-name,.sidebar-user-role{display:none;}.main-content{margin-left:60px;}}
@yield('extra-styles')
</style>
</head>
<body>
<div class="dashboard-layout">
  <div class="sidebar">
    <a class="sidebar-logo" href="{{ route('landing') }}">
      <div class="sidebar-logo-mark"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14v-4H7l5-8v4h4l-5 8z"/></svg></div>
      <span class="sidebar-logo-text">Atamagri</span>
    </a>
    @yield('sidebar-menu')
    <div class="sidebar-spacer"></div>
    <div style="margin-bottom:.75rem;">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="sidebar-item" type="submit" style="width:100%;background:none;border:none;">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
          <span>Keluar</span>
        </button>
      </form>
    </div>
    <div class="sidebar-user">
      <div class="sidebar-user-avatar">{{ auth()->user()->initials }}</div>
      <div>
        <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
        <div class="sidebar-user-role">{{ ucfirst(auth()->user()->role) }}</div>
      </div>
    </div>
  </div>

  <div class="main-content">
    @yield('content')
  </div>
</div>

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
