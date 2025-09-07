<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->pluck('pokemon_name');
        return response()->json($favorites);
    }

    public function store(Request $request)
    {
        $request->validate(['pokemon_name' => 'required|string']);
        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'pokemon_name' => $request->pokemon_name,
        ]);
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $request->validate(['pokemon_name' => 'required|string']);
        Favorite::where('user_id', Auth::id())
            ->where('pokemon_name', $request->pokemon_name)
            ->delete();
        return response()->json(['success' => true]);
    }
}
