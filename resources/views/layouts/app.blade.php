<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/premium.css') }}">

  @yield('styles')
</head>

<body>
  <nav class="glass-nav">
    <div class="container nav-content">
      <a href="{{ url('/') }}" class="logo">MOVIE<span style="color:white">FLIX</span></a>

      <div class="nav-links">
        @auth
          <a href="{{ route('movies.index') }}"
            class="nav-link {{ request()->routeIs('movies.*') ? 'active' : '' }}">{{ __('messages.movies') }}</a>
          <a href="{{ route('favorites.index') }}"
            class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}">{{ __('messages.favorites') }}</a>

          <form action="{{ route('movies.index') }}" method="GET" class="search-container">
            <span
              style="position:absolute; left:0.8rem; top:50%; transform:translateY(-50%); color:var(--text-muted)">🔍</span>
            <input type="text" name="s" class="search-input" placeholder="{{ __('messages.search') }}"
              value="{{ request('s') }}">
          </form>
        @endauth

        <div class="lang-switch" style="display:flex; gap:0.5rem; align-items:center;">
          <a href="{{ route('lang.switch', 'en') }}" class="nav-link {{ app()->getLocale() == 'en' ? 'active' : '' }}"
            style="font-size:0.8rem">EN</a>
          <span style="color:var(--text-muted)">|</span>
          <a href="{{ route('lang.switch', 'id') }}" class="nav-link {{ app()->getLocale() == 'id' ? 'active' : '' }}"
            style="font-size:0.8rem">ID</a>
        </div>

        @auth
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-logout">Logout</button>
          </form>
        @endauth
      </div>
    </div>
  </nav>

  <main class="main-content">
    <div class="container">
      @yield('content')
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  @yield('scripts')
</body>

</html>