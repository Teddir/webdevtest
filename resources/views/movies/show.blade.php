@extends('layouts.app')

@section('content')
  <div class="detail-container">
    <div class="immersive-header">
      <div class="header-backdrop"
        style="background-image: url('{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://placehold.co/1200x600/1e1e1e/333333?text=' }}')">
      </div>
      <div class="header-gradient"></div>
      <div class="container header-content">
        <h1 class="detail-title fade-in">{{ $movie['Title'] }}</h1>
        <div class="fade-in" style="animation-delay: 0.2s">
          <span class="detail-meta-item">{{ $movie['Year'] }}</span>
          <span class="detail-meta-item">{{ $movie['Rated'] ?? 'N/A' }}</span>
          <span class="detail-meta-item">{{ $movie['Runtime'] ?? 'N/A' }}</span>
          <span class="detail-meta-item">{{ $movie['Genre'] ?? 'N/A' }}</span>
        </div>
      </div>
    </div>

    <div class="detail-layout">
      <div class="fade-in" style="animation-delay: 0.4s">
        <img class="detail-poster"
          src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://placehold.co/400x600/1e1e1e/666666?text=No+Poster' }}"
          alt="{{ $movie['Title'] }}" onerror="this.src='https://placehold.co/400x600/1e1e1e/666666?text=No+Poster'">
      </div>

      <div class="fade-in" style="animation-delay: 0.6s">
        <div class="detail-fav-container">
          <button id="fav-btn" class="btn {{ $isFavorite ? 'btn-danger' : 'btn-primary' }}"
            data-imdbid="{{ $movie['imdbID'] }}" data-title="{{ $movie['Title'] }}" data-poster="{{ $movie['Poster'] }}"
            data-year="{{ $movie['Year'] }}" data-type="{{ $movie['Type'] }}">
            <span class="icon">{{ $isFavorite ? '❤️' : '🤍' }}</span>
            <span
              class="text">{{ $isFavorite ? __('messages.remove_from_favorites') : __('messages.add_to_favorites') }}</span>
          </button>
        </div>

        <div class="detail-plot">
          {{ $movie['Plot'] }}
        </div>

        <div class="detail-info-grid">
          <strong>Director:</strong> <span>{{ $movie['Director'] }}</span>
          <strong>Writer:</strong> <span>{{ $movie['Writer'] }}</span>
          <strong>Actors:</strong> <span>{{ $movie['Actors'] }}</span>
          <strong>Language:</strong> <span>{{ $movie['Language'] }}</span>
          <strong>Awards:</strong> <span>{{ $movie['Awards'] }}</span>
          <strong>IMDb Rating:</strong> <span style="color:var(--primary)">★ {{ $movie['imdbRating'] }} / 10</span>
        </div>

        <div style="margin-top: 3rem;">
          <a href="javascript:history.back()" class="nav-link">← {{ __('messages.back') }}</a>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $('#fav-btn').click(function () {
      const btn = $(this);
      const imdbId = btn.data('imdbid');
      const isFavorite = btn.hasClass('btn-danger');

      if (isFavorite) {
        // Remove from favorite
        $.ajax({
          url: `/favorites/${imdbId}`,
          type: 'DELETE',
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function (response) {
            btn.removeClass('btn-danger').addClass('btn-primary');
            btn.find('.icon').text('🤍');
            btn.find('.text').text("{{ __('messages.add_to_favorites') }}");
          }
        });
      } else {
        // Add to favorite
        $.ajax({
          url: "{{ route('favorites.store') }}",
          type: 'POST',
          data: {
            _token: "{{ csrf_token() }}",
            imdb_id: imdbId,
            title: btn.data('title'),
            poster: btn.data('poster'),
            year: btn.data('year'),
            type: btn.data('type')
          },
          success: function (response) {
            btn.removeClass('btn-primary').addClass('btn-danger');
            btn.find('.icon').text('❤️');
            btn.find('.text').text("{{ __('messages.remove_from_favorites') }}");
          }
        });
      }
    });
  </script>
@endsection