@extends('layouts.app')
@section('content')

	<div class="container py-5">
		<div class="row">
			<div class="col-12">
				@include('alerts')
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-9 card-body">
				<form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>
						<div class="col-md-6">
							<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required autofocus>
							@if ($errors->has('name'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

						<div class="col-md-6">
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

							@if ($errors->has('email'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Penjar foto') }}</label>

						<div class="col-md-6">
							<input id="photo" type="file" class="form-control{{ $errors->has('photo') ? ' is-invalid' : '' }}" name="photo" value="{{ $user->photo }}">

							@if ($errors->has('photo'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('photo') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group row justify-content-center mb-0">
						<div class="col-md-3">
							<button type="submit" class="btn btn-success btn-block">
								{{ __('Guardar') }}
							</button>
						</div>
						<div class="col-md-3">
							<a href="{{ route('profile.show') }}" class="btn btn-warning btn-block">
								{{ __('Cancelar') }}
							</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row justify-content-center">
			<a class="btn btn-danger" onclick='return confirm("Estas segur que el vols eliminar?")' href="{{ route('profile.drop', $user->id) }}">{{ __('Eliminar perfil') }}</a>
		</div>
	</div>
@endsection