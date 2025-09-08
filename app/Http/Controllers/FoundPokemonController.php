<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FoundPokemon;

class FoundPokemonController extends Controller
{
    public function index()
    {
        $found = Auth::user()->foundPokemon()->pluck('pokemon_name');
        return response()->json($found);
    }

    public function store(Request $request)
    {
        $request->validate(['pokemon_name' => 'required|string']);
        $user = Auth::user();
        $found = FoundPokemon::firstOrCreate([
            'user_id' => $user->id,
            'pokemon_name' => $request->pokemon_name,
        ]);
        // Only increment if this was a new find
        if ($found->wasRecentlyCreated) {
            $user->increment('found_count');
        }
        return response()->json(['success' => true, 'found_count' => $user->found_count]);
    }

}
