<?php

use App\Http\Controllers\PokedexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PokedexController::class, 'loadPokemon'])->name('pokedex');