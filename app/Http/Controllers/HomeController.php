<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $pokemonData = Cache::get('original_151_pokemon');
        if (!$pokemonData) {
            $pokemonData = $this->fetchOriginal151Pokemon();
            Cache::put('original_151_pokemon', $pokemonData, 60 * 24 * 7);
        }
        return view('welcome', ['pokemonData' => $pokemonData]);
    }

    protected function fetchOriginal151Pokemon()
    {
        $response = file_get_contents('https://pokeapi.co/api/v2/pokemon?limit=151');
        $data = json_decode($response, true);
        $pokemonList = $data['results'] ?? [];
        $pokemonData = [];
        foreach ($pokemonList as $index => $pokemon) {
            $id = $index + 1;
            $pokemonData[] = [
                'name' => ucfirst($pokemon['name']),
                'image' => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{$id}.png",
                'url' => $pokemon['url'],
            ];
        }
        return $pokemonData;
    }
}
