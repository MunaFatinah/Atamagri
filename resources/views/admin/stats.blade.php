@extends('layouts.dashboard')
@section('title', 'Statistik')

@section('sidebar-menu')
<div class="sidebar-section">Admin Panel</div>
<a class="sidebar-item" href="{{ route('admin.index') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
  <span>Dashboard</span>
</a>
<a class="sidebar-item" href="{{ route('admin.users') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
  <span>Kelola Pengguna</span>
</a>
<a class="sidebar-item active" href="{{ route('admin.stats') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
  <span>Statistik</span>
</a>
<a class="sidebar-item" href="{{ route('landing') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14v-4H7l5-8v4h4l-5 8z"/></svg>
  <span>Lihat Website</span>
</a>
@endsection

@section('content')
<div class="main-header"><div><h1>Statistik</h1><p>Data registrasi pengguna tahun {{ now()->year }}</p></div></div>
<div class="main-body">
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-bottom:2rem;">
    <div class="card"><div class="card-body" style="text-align:center;">
      <div style="font-family:var(--font-display);font-size:3rem;font-weight:700;color:var(--green-dark);">{{ $stats['total'] }}</div>
      <div style="color:var(--gray-500);">Total Petani</div>
    </div></div>
    <div class="card"><div class="card-body" style="text-align:center;">
      <div style="font-family:var(--font-display);font-size:3rem;font-weight:700;color:var(--green-mid);">{{ $stats['aktif'] }}</div>
      <div style="color:var(--gray-500);">Petani Aktif</div>
    </div></div>
    <div class="card"><div class="card-body" style="text-align:center;">
      <div style="font-family:var(--font-display);font-size:3rem;font-weight:700;color:#e57373;">{{ $stats['nonaktif'] }}</div>
      <div style="color:var(--gray-500);">Petani Nonaktif</div>
    </div></div>
  </div>

  <div class="card">
    <div class="card-header"><h3>Registrasi per Bulan ({{ now()->year }})</h3></div>
    <div class="card-body">
      @php
        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $byMonth = $stats['users_by_month']->keyBy('month');
        $maxCount = max($stats['users_by_month']->max('count') ?: 1, 1);
      @endphp
      <div style="display:flex;align-items:flex-end;gap:.5rem;height:200px;padding-bottom:1.5rem;border-bottom:2px solid var(--gray-200);">
        @foreach($months as $i => $m)
        @php $count = $byMonth->get($i+1)?->count ?? 0; $h = $maxCount > 0 ? round(($count/$maxCount)*180) : 0; @endphp
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:.35rem;">
          <span style="font-size:.72rem;color:var(--gray-500);">{{ $count > 0 ? $count : '' }}</span>
          <div style="width:100%;height:{{ $h }}px;background:{{ $count > 0 ? 'var(--green-light)' : 'var(--gray-200)' }};border-radius:4px 4px 0 0;transition:height .4s;"></div>
          <span style="font-size:.72rem;color:var(--gray-500);">{{ $m }}</span>
        </div>
        @endforeach
      </div>
      <p style="font-size:.82rem;color:var(--gray-500);margin-top:1rem;text-align:center;">Total registrasi sepanjang {{ now()->year }}</p>
    </div>
  </div>
</div>
@endsection