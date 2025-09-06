<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PokePHP\PokeApi;

class HomeController extends Controller
{
    public function index()
    {
        // Try to get cached Pokémon data
        $pokemon = Cache::get('original_151_pokemon');
        if (!$pokemon) {
            $api = new PokeApi();
            $data = json_decode($api->pokemon(['limit' => 151]), true);
            $pokemonList = $data['results'] ?? [];

            $pokemon = [];
            foreach ($pokemonList as $poke) {
                $pokeDetails = json_decode($api->pokemon($poke['name']), true);
                $types = array_map(function($type) {
                    return [
                        'name' => $type['type']['name'],
                    ];
                }, $pokeDetails['types']);
                $pokemon[] = [
                    'name' => ucfirst($pokeDetails['name']),
                    'image' => $pokeDetails['sprites']['other']['official-artwork']['front_default'],
                    'types' => $types,
                ];
            }
            // Cache for 24 hours
            Cache::put('original_151_pokemon', $pokemon, 60 * 24);
        }
        return view('welcome', compact('pokemon'));
    }
}
