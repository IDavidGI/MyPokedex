<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPok&eacute;dex</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pokeball.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/types.css') }}">
</head>

<body class="bg-light">
    <nav style="height: 100px" class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}" style="margin-left: 30px">
                <img src="{{ asset('images/pokeball.png') }}" width="30" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">My Pok&eacute;dex</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Favorites</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Register</a>
                    </li>
                    <li class="nav-item" style="margin-right: 30px;">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid" style="padding-left:50px; margin-left:0px;">
        <div class="row" style="height: 85vh; width: 100%;">
            <div class="col-8" style="height: 100%; padding-left:0; margin-left:0; width:65%; max-width:65vw; flex:0 0 65%;">
                <div class="d-flex align-items-center mb-3" style="gap: 16px;">
                    <input id="pokemon-search" type="text" class="form-control" placeholder="Search Pokémon by name..." style="max-width: 220px;">
                    <div class="dropdown">
                        <button class="btn btn-outline-success dropdown-toggle" type="button" id="typeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
</body>

</html>