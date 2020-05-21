@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
<div class="page-content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-lg">
				<div class="alert">
					@include('alerts')
					<h1 class="text-center">El meu compte</h1>
				</div>
			</div>
		</div>
		<div class="row border justify-content-center align-content-center py-4 mx-1 mx-md-0">
			<div class="col-6 col-md-4 col-lg-3 text-center mb-3 mb-md-0">
				<div class="profile-header-img">
					<img class="rounded" src="/uploads/users/{{ $user->photo }}" />
				</div>
			</div>
			<div class="col-10 text-center text-md-left col-md-7 col-lg-6 offset-md-1 offset-lg-2 align-self-center">
				<div class="row py-2">
					<div class="col-md-4"><strong>Nom</strong></div>
					<div class="col-md-6">{{ $user->name }}</div>
				</div>
				<div class="row py-2">
					<div class="col-md-4"><strong>E-mail</strong></div>
					<div class="col-md-6">{{ $user->email }}</div>
				</div>

				<div class="row my-3">
					<div class="col-md-6 offset-md-4">
						<a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">
						<i class="far fa-edit"></i> Editar Perfil
						</a>
					</div>
				</div>
				
			</div>
		</div>
		<br>
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