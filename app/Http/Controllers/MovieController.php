<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MovieService;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
  protected $movieService;

  public function __construct(MovieService $movieService)
  {
    $this->movieService = $movieService;
  }

  public function index(Request $request)
  {
    $query = $request->input('s', 'Marvel');
    $movies = [];

    $result = $this->movieService->search($query);
    if (isset($result['Search'])) {
      $movies = $result['Search'];
    }

    return view('movies.index', compact('movies'));
  }

  public function search(Request $request)
  {
    $query = $request->input('s');
    $page = $request->input('page', 1);

    $result = $this->movieService->search($query, $page);

    return response()->json($result);
  }

  public function show($id)
  {
    $movie = $this->movieService->getDetail($id);

    $isFavorite = false;
    if (Auth::check()) {
      $isFavorite = Favorite::where('user_id', Auth::id())
        ->where('imdb_id', $id)
        ->exists();
    }

    return view('movies.show', compact('movie', 'isFavorite'));
  }
}
