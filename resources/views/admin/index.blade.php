@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')

@section('extra-styles')
.admin-stat{background:var(--white);border-radius:16px;padding:1.75rem;border:1px solid var(--gray-200);text-align:center;}
.admin-stat .big{font-family:var(--font-display);font-size:3rem;font-weight:700;color:var(--green-dark);}
.admin-stat .lbl{font-size:.9rem;color:var(--gray-500);margin-top:.4rem;}
@endsection

@section('sidebar-menu')
<div class="sidebar-section">Admin Panel</div>
<a class="sidebar-item active" href="{{ route('admin.index') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
  <span>Dashboard</span>
</a>
<a class="sidebar-item" href="{{ route('admin.users') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
  <span>Kelola Pengguna</span>
</a>
<a class="sidebar-item" href="{{ route('admin.stats') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
  <span>Statistik</span>
</a>
<div class="sidebar-section" style="margin-top:1rem;">Sistem</div>
<a class="sidebar-item" href="{{ route('landing') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14v-4H7l5-8v4h4l-5 8z"/></svg>
  <span>Lihat Website</span>
</a>
@endsection

@section('content')
<div class="main-header">
  <div><h1>Admin Dashboard</h1><p>Selamat datang, {{ auth()->user()->name }}</p></div>
</div>
<div class="main-body">
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:2rem;">
    <div class="admin-stat"><div class="big">{{ $stats['total_users'] }}</div><div class="lbl">Total Petani</div></div>
    <div class="admin-stat"><div class="big" style="color:var(--green-mid);">{{ $stats['aktif'] }}</div><div class="lbl">Petani Aktif</div></div>
    <div class="admin-stat"><div class="big" style="color:#e57373;">{{ $stats['nonaktif'] }}</div><div class="lbl">Petani Nonaktif</div></div>
    <div class="admin-stat"><div class="big" style="color:#f9c74f;">{{ $stats['total_testimoni'] }}</div><div class="lbl">Total Testimoni</div></div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    <div class="card">
      <div class="card-header"><h3>⚡ Aksi Cepat</h3></div>
      <div class="card-body" style="display:grid;gap:.75rem;">
        <a href="{{ route('admin.users') }}" class="btn btn-primary">👥 Kelola Pengguna</a>
        <a href="{{ route('admin.stats') }}" class="btn btn-outline">📊 Lihat Statistik</a>
        <a href="{{ route('cuaca') }}" class="btn btn-outline" target="_blank">🌤️ Cek Cuaca</a>
        <a href="{{ route('rekomendasi') }}" class="btn btn-outline" target="_blank">🌱 Rekomendasi Tanam</a>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3>ℹ️ Info Sistem</h3></div>
      <div class="card-body">
        <div style="display:grid;gap:.75rem;">
          <div style="display:flex;justify-content:space-between;"><span style="font-size:.85rem;color:var(--gray-500);">OWM API</span><span style="font-size:.85rem;font-weight:600;color:{{ config('services.owm.key') ? 'var(--green-mid)' : '#e57373' }};">{{ config('services.owm.key') && config('services.owm.key') !== 'YOUR_OWM_API_KEY_HERE' ? '✅ Terhubung' : '⚠️ Belum diatur' }}</span></div>
          <div style="display:flex;justify-content:space-between;"><span style="font-size:.85rem;color:var(--gray-500);">Gemini AI</span><span style="font-size:.85rem;font-weight:600;color:{{ config('services.gemini.key') ? 'var(--green-mid)' : '#e57373' }};">{{ config('services.gemini.key') && config('services.gemini.key') !== 'YOUR_GEMINI_API_KEY_HERE' ? '✅ Terhubung' : '⚠️ Belum diatur' }}</span></div>
          <div style="display:flex;justify-content:space-between;"><span style="font-size:.85rem;color:var(--gray-500);">Laravel</span><span style="font-size:.85rem;font-weight:600;">{{ app()->version() }}</span></div>
          <div style="display:flex;justify-content:space-between;"><span style="font-size:.85rem;color:var(--gray-500);">PHP</span><span style="font-size:.85rem;font-weight:600;">{{ PHP_VERSION }}</span></div>
          <div style="display:flex;justify-content:space-between;"><span style="font-size:.85rem;color:var(--gray-500);">Environment</span><span style="font-size:.85rem;font-weight:600;">{{ app()->environment() }}</span></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
