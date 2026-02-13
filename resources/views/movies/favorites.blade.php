@extends('layouts.app')

@section('content')
  <h1 class="fade-in" style="margin-bottom: 2rem; font-weight: 800; letter-spacing: -1px;">{{ __('messages.favorites') }}
  </h1>

  <div id="movie-grid" class="movie-grid fade-in" style="animation-delay: 0.2s">
    @forelse($favorites as $favorite)
      <div class="movie-card" data-imdbid="{{ $favorite->imdb_id }}"
        onclick="window.location='{{ route('movies.show', $favorite->imdb_id) }}'">
        <img class="movie-poster"
          src="{{ $favorite->poster !== 'N/A' ? $favorite->poster : 'https://placehold.co/400x600/1e1e1e/666666?text=No+Poster' }}"
          alt="{{ $favorite->title }}" onerror="this.src='https://placehold.co/400x600/1e1e1e/666666?text=No+Poster'"
          loading="lazy">
        <div class="movie-info">
          <div class="movie-title">{{ $favorite->title }}</div>
          <div class="movie-meta">{{ $favorite->year }} • {{ ucfirst($favorite->type) }}</div>
        </div>

        <button class="remove-fav-btn"
          style="position:absolute; top:10px; right:10px; background:rgba(0,0,0,0.6); border:none; color:white; border-radius:50%; width:32px; height:32px; cursor:pointer; display:none; align-items:center; justify-content:center;"
          onclick="event.stopPropagation(); removeFavorite('{{ $favorite->imdb_id }}')">
          ✕
        </button>
      </div>
    @empty
      <div style="grid-column: 1/-1; text-align: center; padding: 5rem;">
        <h2 style="color: var(--text-muted)">{{ __('messages.no_favorites') }}</h2>
        <div style="margin-top: 2rem;">
          <a href="{{ route('movies.index') }}" class="btn btn-primary">{{ __('messages.search') }}</a>
        </div>
      </div>
    @endforelse
  </div>

  <style>
    .movie-card:hover .remove-fav-btn {
      display: flex !important;
    }

    .remove-fav-btn:hover {
      background: var(--primary) !important;
    }
  </style>
@endsection

@section('scripts')
  <script>
    function removeFavorite(imdbId) {
      if (confirm("{{ __('messages.remove_from_favorites') }}?")) {
        $.ajax({
          url: `/favorites/${imdbId}`,
          type: 'DELETE',
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function (response) {
            $(`.movie-card[data-imdbid="${imdbId}"]`).fadeOut(300, function () {
              $(this).remove();
              if ($('.movie-card').length === 0) {
                location.reload();
              }
            });
          }
        });
      }
    }
  </script>
@endsection