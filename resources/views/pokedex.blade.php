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
                        <a class="nav-link active" aria-current="page" href="#">My Pok&eacute;dex</a>
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
            <div class="col-6" style="height: 100%; padding-left:0; margin-left:0;">
                <div style="height: 100%; overflow-y: auto; border: 3px solid black;">
                    <div class="row row-cols-2 row-cols-md-4 g-2" style="margin: 0px 8px 0px 8px;">
                    @foreach ($pokemonData as $index => $pokemon)
                        <div class="col">
                            <div class="card pokemon-list-item h-100 shadow-lg text-center" data-index="{{ $index }}"
                                data-url="{{ $pokemon['url'] }}" style="cursor:pointer; min-height:220px; font-size:1.15em;">
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
            <div class="col-6 d-flex align-items-center justify-content-center" style="height: 100%;">
                <div id="pokemon-details" style="width:100%; max-width:400px;"></div>
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