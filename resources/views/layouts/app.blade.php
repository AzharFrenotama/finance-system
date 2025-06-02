<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Sistem Manajemen Keuangan')</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  @yield('extra_css')
</head>
<body class="{{ session('dark_mode', false) ? 'dark' : '' }}">
  <header>
    <h1>Sistem Manajemen Keuangan Pribadi</h1>
    <nav>
      <ul>
        <li data-tab="dashboard" class="{{ request()->is('dashboard*') ? 'active' : '' }}">
          <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li data-tab="transaksi" class="{{ request()->is('transactions*') ? 'active' : '' }}">
          <a href="{{ route('transactions.index') }}">Transaksi</a>
        </li>
        <li data-tab="anggaran" class="{{ request()->is('budgets*') ? 'active' : '' }}">
          <a href="{{ route('budgets.index') }}">Anggaran</a>
        </li>
        <li data-tab="laporan" class="{{ request()->is('reports*') ? 'active' : '' }}">
          <a href="{{ route('reports.index') }}">Laporan</a>
        </li>
      </ul>
      <button id="darkModeToggle" data-url="{{ route('toggle.darkmode') }}">🌓</button>
    </nav>
  </header>

  <main>
    @yield('content')
  </main>

  <div id="notifikasi" class="notifikasi {{ session('notification') ? 'show' : '' }}">
    {{ session('notification') ?? 'Berhasil!' }}
  </div>

  <script>
    // Base URL untuk API
    const baseApiUrl = "{{ url('/api') }}";
    // User ID
    const currentUserId = {{ auth()->id() ?? 'null' }};
  </script>
  <script src="{{ asset('js/script.js') }}"></script>
  @yield('extra_js')
</body>
</html>