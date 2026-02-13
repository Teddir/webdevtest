@extends('layouts.app')

@section('content')
  <div class="hero-section fade-in">
    <h1 class="hero-title">EXPLORE THE <span style="color:var(--primary)">CINEMA</span></h1>
    <p class="hero-subtitle">
      {{ __('messages.search_subtitle') ?? 'Discover your next favorite story. Search through thousands of titles in our premium collection.' }}
    </p>
  </div>

  <div id="movie-grid" class="movie-grid fade-in">
    @forelse($movies as $movie)
      <div class="movie-card" onclick="window.location='{{ route('movies.show', $movie['imdbID']) }}'">
        <img class="movie-poster"
          src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://placehold.co/400x600/1e1e1e/666666?text=No+Poster' }}"
          alt="{{ $movie['Title'] }}" onerror="this.src='https://placehold.co/400x600/1e1e1e/666666?text=No+Poster'"
          loading="lazy">
        <div class="movie-info">
          <div class="movie-title">{{ $movie['Title'] }}</div>
          <div class="movie-meta">{{ $movie['Year'] }} • {{ ucfirst($movie['Type']) }}</div>
        </div>
      </div>
    @empty
      <div style="grid-column: 1/-1; text-align: center; padding: 5rem;" class="fade-in">
        @if(request('s'))
          <h2 style="color: var(--text-muted)">{{ __('messages.no_results') }}</h2>
        @else
          <h2 style="color: var(--text-muted)">{{ __('messages.search_prompt') ?? 'Search for a movie above to get started' }}
          </h2>
        @endif
      </div>
    @endforelse
  </div>

  <div id="skeleton-container" class="skeleton-grid" style="display: none;">
    @for($i = 0; $i < 8; $i++)
      <div class="skeleton-card">
        <div class="skeleton-poster skeleton"></div>
        <div class="skeleton-text-wrap">
          <div class="skeleton-title skeleton"></div>
          <div class="skeleton-meta skeleton"></div>
        </div>
      </div>
    @endfor
  </div>

  <div id="loading-indicator">
    <div
      style="display:inline-block; width:40px; height:40px; border:4px solid rgba(255,255,255,0.1); border-top:4px solid var(--primary); border-radius:50%; animation: spin 1s linear infinite;">
    </div>
  </div>

  <style>
    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
@endsection

@section('scripts')
  <script>
    let page = 1;
    let loading = false;
    let hasMore = true;
    const query = "{{ request('s') }}" || "Marvel";

    $(window).scroll(function () {
      if (!hasMore || loading) return;

      if ($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
        loadMore();
      }
    });

    function loadMore() {
      loading = true;
      $('#loading-indicator').hide();
      $('#skeleton-container').show();
      page++;

      $.ajax({
        url: "{{ route('movies.search') }}",
        data: { s: query, page: page },
        success: function (data) {
          if (data.Response === 'True') {
            $.each(data.Search, function (index, movie) {
              const poster = movie.Poster !== 'N/A' ? movie.Poster : 'https://placehold.co/400x600/1e1e1e/666666?text=No+Poster';
              const card = `
                                                <div class="movie-card" onclick="window.location='/movies/${movie.imdbID}'">
                                                    <img class="movie-poster" src="${poster}" alt="${movie.Title}" onerror="this.src='https://placehold.co/400x600/1e1e1e/666666?text=No+Poster'" loading="lazy">
                                                    <div class="movie-info">
                                                        <div class="movie-title">${movie.Title}</div>
                                                        <div class="movie-meta">${movie.Year} • ${movie.Type.charAt(0).toUpperCase() + movie.Type.slice(1)}</div>
                                                    </div>
                                                </div>
                                            `;
              $('#movie-grid').append(card);
            });
          } else {
            hasMore = false;
          }
          $('#skeleton-container').hide();
          loading = false;
        },
        error: function () {
          $('#skeleton-container').hide();
          loading = false;
        }
      });
    }
  </script>
@endsection