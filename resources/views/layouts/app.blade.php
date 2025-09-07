<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPok&eacute;dex</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/pokeball.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/types.css') }}">
</head>
<body>
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
                </ul>
                <div class="mx-auto d-flex align-items-center justify-content-center" style="min-width:220px;">
                    @auth
                        <span class="badge rounded-pill text-white" style="font-size:1.2em; padding:12px 28px; box-shadow:0 2px 8px #eee; background: linear-gradient(105deg, #e53935 0%, #e53935 40%, #1e88e5 60%, #1e88e5 100%); border: 2px solid #fff;">
                            {{ Auth::user()->name }}'s Pokédex
                        </span>
                    @endauth
                </div>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                        <li class="nav-item" style="margin-right: 30px;">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @else
                        <li class="nav-item dropdown" style="margin-right: 30px;">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
</body>
</html>
