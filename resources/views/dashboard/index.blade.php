@extends('layouts.dashboard')
@section('title', 'Dashboard Petani')

@section('sidebar-menu')
<div class="sidebar-section">Menu</div>
<a class="sidebar-item active" href="{{ route('dashboard.index') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
  <span>Dashboard</span>
</a>
<a class="sidebar-item" href="{{ route('dashboard.cuaca') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.79 1.42-1.41zM4 10.5H1v2h3v-2zm9-9.95h-2V3.5h2V.55zm7.45 3.91l-1.41-1.41-1.79 1.79 1.41 1.41 1.79-1.79zm-3.21 13.7l1.79 1.8 1.41-1.41-1.8-1.79-1.4 1.4zM20 10.5v2h3v-2h-3zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm-1 16.95h2V19.5h-2v2.95zm-7.45-3.91l1.41 1.41 1.79-1.8-1.41-1.41-1.79 1.8z"/></svg>
  <span>Cuaca</span>
</a>
<a class="sidebar-item" href="{{ route('dashboard.rekomendasi') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 0 0 8 20c9 0 14-8 14-8-1 2-4 5-5 5-3 0-3-2.5-5-2.5S9 17 6 17c1-3 4-8 11-9z"/></svg>
  <span>Rekomendasi</span>
</a>
<a class="sidebar-item" href="{{ route('dashboard.profil') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
  <span>Profil Saya</span>
</a>
<div class="sidebar-section" style="margin-top:1rem;">Publik</div>
<a class="sidebar-item" href="{{ route('cuaca') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
  <span>Cek Cuaca</span>
</a>
@endsection

@section('content')
<div class="main-header">
  <div>
    <h1>Selamat datang, {{ $user->name }} 👋</h1>
    <p>{{ now()->translatedFormat('l, d F Y') }}</p>
  </div>
</div>
<div class="main-body">
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon green">🌤️</div>
      <div><div class="stat-val">—</div><div class="stat-lbl">Cuaca Hari Ini</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green">🌱</div>
      <div><div class="stat-val">6</div><div class="stat-lbl">Rekomendasi Tanam</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon blue">📍</div>
      <div><div class="stat-val">{{ $user->location ?: '-' }}</div><div class="stat-lbl">Lokasi Anda</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon orange">📅</div>
      <div><div class="stat-val">{{ $user->created_at->diffForHumans(null, true) }}</div><div class="stat-lbl">Bergabung</div></div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    <div class="card">
      <div class="card-header"><h3>🌤️ Monitoring Cuaca</h3></div>
      <div class="card-body">
        <p style="color:var(--gray-500);font-size:.9rem;margin-bottom:1rem;">Pantau kondisi cuaca terkini di lokasi lahan Anda.</p>
        <a href="{{ route('dashboard.cuaca') }}" class="btn btn-primary">Cek Cuaca Sekarang</a>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3>🌱 Rekomendasi Tanam</h3></div>
      <div class="card-body">
        <p style="color:var(--gray-500);font-size:.9rem;margin-bottom:1rem;">Dapatkan saran tanaman terbaik berdasarkan AI dan cuaca terkini.</p>
        <a href="{{ route('dashboard.rekomendasi') }}" class="btn btn-primary">Lihat Rekomendasi</a>
      </div>
    </div>
  </div>
</div>
@endsection
