<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Original 151 Pokémon</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/types.css') }}">
</head>
<body class="bg-light">
	<div class="container py-4">
		<h1 class="mb-4 text-center">Original 151 Pokémon</h1>
		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
			@foreach ($pokemon as $poke)
				<div class="col">
					<div class="card h-100 shadow-sm">
						<img src="{{ $poke['image'] }}" class="card-img-top bg-white p-3" alt="{{ $poke['name'] }}">
						<div class="card-body text-center">
							<h5 class="card-title">{{ $poke['name'] }}</h5>
							<div>
								@foreach ($poke['types'] as $type)
									<span class="type-badge type-{{ $type['name'] }}">{{ ucfirst($type['name']) }}</span>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>