@extends('layouts.app')
@section('content')
@auth
<body class="bg-light">
    <div class="container-fluid" style="padding-left:50px; margin-left:0px;">
        <div class="row" style="height: 85vh; width: 100%;">
            <div class="col-8" style="height: 100%; padding-left:0; margin-left:0; width:65%; max-width:65vw; flex:0 0 65%;">
                <div class="d-flex align-items-center mb-3" style="gap: 12px;">
                    <input id="pokemon-search" type="text" class="form-control" placeholder="Search Pokémon by name..." style="max-width: 220px;">  
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="typeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter by Type
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="typeDropdown" id="type-filter-menu">
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="">All Types</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="normal">Normal</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="fire">Fire</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="water">Water</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="electric">Electric</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="grass">Grass</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="ice">Ice</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="fighting">Fighting</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="poison">Poison</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="ground">Ground</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="flying">Flying</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="psychic">Psychic</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="bug">Bug</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="rock">Rock</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="ghost">Ghost</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="dragon">Dragon</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="steel">Steel</a></li>
                            <li><a class="dropdown-item type-filter-option" href="#" data-type="fairy">Fairy</a></li>
                        </ul>
                    </div>
                    <button id="favorites-filter-btn" class="btn btn-warning" type="button">Favorites</button>
                    <div class="flex-grow-1" style="min-width:200px; max-width:700px;">
                        <div class="progress" style="height: 28px; background-color: #eee;">
                                <div style="position: relative; width: 100%; height: 100%;">
                                    <div id="found-progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%; height: 100%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="151"></div>
                                    <span id="found-progress-text" style="position: absolute; left: 0; right: 0; top: 0; bottom: 0; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.5em; color: #ffff; pointer-events: none;">0 / 151 Found</span>
                                </div>
                        </div>
                    </div>
                </div>
                <div style="height: 95%; overflow-y: auto; border: 3px solid grey; padding: 16px;">
                    <div class="row row-cols-2 row-cols-md-5 g-2" style="margin: 0px 8px 8px 8px;" id="pokemon-grid">
                    @foreach ($pokemonData as $index => $pokemon)
                        <div class="col">
                            <div class="card pokemon-list-item h-100 shadow-lg text-center position-relative" data-index="{{ $index }}"
                                data-url="{{ $pokemon['url'] }}" style="cursor:pointer; min-height:220px; font-size:1.15em;">
                                <button class="favorite-btn" style="position:absolute; top:10px; right:10px; background:transparent; border:none; z-index:3; font-size:1.5em; color:#FFD700;" title="Favorite">
                                    <span class="favorite-star" data-index="{{ $index }}">&#9734;</span>
                                </button>
                                <img src="{{ $pokemon['image'] }}" alt="{{ $pokemon['name'] }}"
                                    style="width:100px; height:100px; object-fit:contain; margin:18px auto 0;">
                                <div class="card-body p-3">
                                    <div class="card-title" style="font-size:1.2em; font-weight:bold;">{{ $pokemon['name'] }}
                                    </div>
                                    <div class="pokemon-type-list" style="margin-top:8px; min-height:28px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
            <div class="col-4 d-flex align-items-center justify-content-center" style="height: 100%; width:35%; max-width:35vw; flex:0 0 35%;">
                <div style="width:100%; max-width:400px; display: flex; flex-direction: column; align-items: center;">
                    <div id="pokemon-details" style="width:100%; max-width:400px;"></div>
                    <div id="evolution-chain" style="margin-top:24px; display:flex; align-items:center; justify-content:center; gap:18px;"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const pokemonData = @json($pokemonData);
    </script>
    <script src="{{ asset('js/pokemondetails.js') }}"></script>
    <script src="{{ asset('js/pokemonfavorites.js') }}"></script>
    <script src="{{ asset('js/pokemonfilter.js') }}"></script>
@endauth
@guest
<div class="container d-flex flex-column justify-content-center align-items-center" style="height: 80vh;">
    <div class="card shadow-lg p-4" style="max-width: 480px;">
        <h1 class="mb-3 text-center" style="font-size:2.2em; font-weight:bold;">Welcome to MyPokédex!</h1>
        <p class="mb-4 text-center" style="font-size:1.2em;">Created by David Geuchenmeier</p>
        <p class="text-center">Please <a href="{{ route('login') }}" class="btn btn-primary">login</a> or <a href="{{ route('register') }}" class="btn btn-primary">Register</a> to access your Pokédex.</p>
    </div>
</div>
@endguest
@endsection