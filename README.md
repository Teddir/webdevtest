# MovieFlix - Premium Laravel 8 Movie Application

MovieFlix is a high-performance movie database explorer built with Laravel 8, optimized for PHP 8.1. It features a modern dark-themed UI, OMDb API integration, and a local favorites management system.

## Performance Features
- **Premium Design**: Dark mode aesthetic with glassmorphism and subtle animations.
- **OMDb API**: Search and detail integration for real-time movie data.
- **Infinite Scrolling**: AJAX-powered results loading.
- **Multi-Language**: Support for English (EN) and Indonesian (ID).
- **Security**: Robust username-based authentication (`aldmic` / `123abc123`).

## Setup Instructions

### Prerequisites
- PHP 8.1+
- Composer
- SQLite

### Installation

1. **Clone the repository**:
   ```bash
   git clone <repository_url>
   cd webdevtest
   ```

2. **Install dependencies**:
   ```bash
   composer install --ignore-platform-reqs
   ```

3. **Environment Setup**:
   Copy `.env.example` to `.env` and ensure the following are set:
   ```text
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/database.sqlite
   OMDB_API_KEY=6f0e0680
   ```

4. **Initialize Database**:
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Serve the Application**:
   ```bash
   php artisan serve
   ```
   Access the app at `http://127.0.0.1:8000`.

## Architecture Overview
- **Services Layer**: `MovieService` handles all OMDb API interactions, abstracting API complexity from the controllers.
- **Models**: `User` (expanded with username) and `Favorite` (handling IMDb-linked user curation).
- **Localization**: Middleware-based locale management for a global user experience.
- **Frontend**: Blade templates integrated with `premium.css` for a monolithic-but-modern visual experience.
