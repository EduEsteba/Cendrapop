@extends('layouts.app')
@section('content')

	<div class="container py-2 py-md-4">
		<div class="row">
			<div class="col-12">
				<div class="alert">
					@include('alerts')
					<h1 class="h2 text-center">{{ __('El meu compte') }}</h1>
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
					<div class="col-md-4"><strong>{{ __('Nom') }}</strong></div>
					<div class="col-md-6">{{ $user->name }}</div>
				</div>
				<div class="row py-2">
					<div class="col-md-4"><strong>{{ __('E-Mail') }}</strong></div>
					<div class="col-md-6">{{ $user->email }}</div>
				</div>

				<div class="row my-3">
					<div class="col-md-6 offset-md-4">
						<a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">
							{{ __('Editar perfil') }}
						</a>
					</div>
				</div>
				
			</div>
		</div>

	</div>
@endsection