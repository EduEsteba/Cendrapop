@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
<div class="page-content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="alert">
					@include('alerts')
					<h1 class="text-center">El meu compte</h1>
				</div>
				<div class=" col-lg-12 col-md-12 col-sm-12 text-center">
					<img class="rounded" src="/uploads/users/{{ $user->photo }}" />
					<br>
					<br>
					<strong>Nom: </strong>{{ $user->name }}
					<br>
					<strong>E-mail: </strong>{{ $user->email }}
					<br>
					<br>
					<a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">
						<i class="far fa-edit"></i> Editar Perfil
						</a>
					</div>
				
			</div>
			</div>
			
		</div>
		
		<br>
		<hr>
		<div class="row">
			<div class="col-12 col-sm-6 text-center text-sm-left mb-4 ">
				<h2 id="products text-center">Els meus productes</h2>
			</div>
		
			@if ($products->count() > 0)
				<div class="col-12 col-sm-6 text-center text-sm-right mb-4">
					<a class="btn btn-success" href="{{ route('products.new') }}"><i class="fas fa-plus"></i> Nou Producte</a>
				</div>
			@endif
		</div>
		@if ($products->count() > 0)
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">#</th>
						<th scope="col">Nom</th>
						<th scope="col">Accions</th>
					</tr>
				</thead>
				<tbody>

					@foreach ($products as $product)
						<tr>
							<th>{{ $loop->iteration }}</th>
							<td><a href="{{ route('products.show', $product->id) }}">{{ $product->title }}</a></td>
							<td>
								<a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary mr-3"><i class="far fa-edit"></i> Editar</a><a href="{{ route('products.drop', $product->id) }}" class="btn btn-danger" onclick='return confirm("Estas segur que vols eliminar?")'><i class="fas fa-trash"></i> Eliminar</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<p>No tens cap producte, a que esperes i comença a vendre!!</p>
			<p><a class="btn btn-success" href="{{ route('products.new') }}"><i class="fas fa-plus"></i> Afegeix un producte</a></p>
		@endif
	</div>
	</div>
	</div>
	
@endsection