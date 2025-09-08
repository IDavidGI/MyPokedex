<?php
use App\Http\Controllers\SimpleAuthController;

use App\Http\Controllers\PokedexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FoundPokemonController;

Route::get('/', [PokedexController::class, 'loadPokemon'])->name('pokedex');

Route::get('/register', [SimpleAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [SimpleAuthController::class, 'register']);
Route::get('/login', [SimpleAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [SimpleAuthController::class, 'login']);
Route::post('/logout', [SimpleAuthController::class, 'logout'])->name('logout');

//routes for favorites
Route::middleware('auth')->group(function () {
	Route::get('/favorites', [FavoriteController::class, 'index']);
	Route::post('/favorites', [FavoriteController::class, 'store']);
	Route::delete('/favorites', [FavoriteController::class, 'destroy']);
});

//routes for found pokemon
Route::middleware('auth')->group(function () {
    Route::get('/found', [FoundPokemonController::class, 'index']);
    Route::post('/found', [FoundPokemonController::class, 'store']);
});