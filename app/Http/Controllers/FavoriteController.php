<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('movies.favorites', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required|string',
            'title' => 'required|string',
            'poster' => 'nullable|string',
            'year' => 'nullable|string',
            'type' => 'nullable|string',
        ]);

        $favorite = Favorite::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'imdb_id' => $request->imdb_id,
            ],
            [
                'title' => $request->title,
                'poster' => $request->poster,
                'year' => $request->year,
                'type' => $request->type,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => __('messages.add_to_favorites'),
            'favorite' => $favorite
        ]);
    }

    public function destroy($id)
    {
        Favorite::where('user_id', Auth::id())
            ->where('imdb_id', $id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => __('messages.remove_from_favorites')
        ]);
    }
}
