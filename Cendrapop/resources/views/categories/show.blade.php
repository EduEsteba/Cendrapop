@extends('layouts.app')

@section('content')

	<div class="container py-5">
		<div class="alert">
			@include('alerts')
		</div>
		<div class="col-12 text-center mb-4">
			<h2>{{ __('Categories') }}</h2>
		</div>
		<div class="text-right">
			<a href="{{ route('categories.new') }}" class="btn btn-primary mb-3">{{ __('Nova Categoria') }}</a>
		</div>
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col">#</th>
					<th scope="col">{{ __('Categoria') }}</th>
					<th scope="col">{{ __('Productes') }}</th>
					<th scope="col">{{ __('Accions') }}</th>
				</tr>
			</thead>
			<tbody>

				@foreach ($categories as $category)
					<tr>
						<th>{{ $loop->iteration }}</th>
						<td>{{ $category->title }}</td>
						<td></td>
						<td>
							<a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary mr-3">{{ __('Edit') }}</a><a href="{{ route('categories.drop', $category->id) }}" class="btn btn-danger" onclick='return confirm("Are you sure?")'>{{ __('Delete') }}</a>
						</td>
					</tr>
				@endforeach
			</tbody>
			
		</table>
	</div>
@endsection