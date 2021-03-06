@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
<div class="container">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<div class="row">
			<div class="col-12">
				@include('alerts')
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-12 card-body center">
			<h1 class="text-center">Editar Perfil</h1>
			<br>
			<br>
				<form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">Nom</label>
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
						<label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>

						<div class="col-md-6">
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

							@if ($errors->has('email'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<!--<div class="form-group row">
						<label for="password" class="col-md-4 col-form-label text-md-right">Contrasenya</label>

						<div class="col-md-6">
							<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ $user->password }}" required>

							@if ($errors->has('password'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
								<label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

								<div class="col-md-6">
									<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
								</div>
							</div>
-->
					<div class="form-group row">
						<label for="photo" class="col-md-4 col-form-label text-md-right">Penjar foto</label>

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
							<i class="fas fa-check"></i> Guardar
							</button>
						</div>
						<div class="col-md-3">
							<a href="{{ route('profile.show') }}" class="btn btn-warning btn-block">
							<i class="fas fa-times"></i> Cancelar
							</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		</div>
		<div class="row justify-content-center">
			<a class="btn btn-danger" onclick='return confirm("Estas segur que el vols eliminar?")' href="{{ route('profile.drop', $user->id) }}"><i class="fas fa-trash"></i> Eliminar perfil</a>
		</div>
	</div>
@endsection
