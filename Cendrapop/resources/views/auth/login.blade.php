

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cendrapop') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/34547ed440.js" crossorigin="anonymous"></script>	  
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/css.css') }}" rel="stylesheet">

</head>
<body>
    <div class="col-sm-12 col-md-12 col-lg-12" >
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header text-center">{{ __('Login') }}</div>

					<div class="card-body">
						<form method="POST" action="{{ route('login') }}">
							@csrf

							<div class="form-group row">
								<label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

								<div class="col-md-6">
									<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

									@if ($errors->has('email'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
									@endif
								</div>
							</div>
							<div class="form-group">
								@if (Request::has('previous'))
									<input type="hidden" name="previous" value="{{ Request::get('previous') }}">
								@else
									<input type="hidden" name="previous" value="{{ URL::previous() }}">
								@endif
							</div>
							<div class="form-group row">
								<label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

								<div class="col-md-6">
									<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

									@if ($errors->has('password'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
									@endif
								</div>
							</div>

							

							<div class="form-group row mb-0">
								<div class="col-md-8 offset-md-4">
									<button type="submit" class="btn btn-primary" id="login">
									Login
									</button>

									<a class="btn btn-success" href="{{ url('/register') }}">
											Registre
										</a>

									@if (Route::has('password.request'))
										<a class="btn btn-link" href="{{ route('password.request') }}">
											Forgot Your Password?
										</a>
									@endif
								</div>
							</div>

						</form>

					</div>

				</div>
				<img src="{{url('/logo/logo_transparent.png')}}" class="img-fluid">

			</div>
		</div>
	</div>


    </div>

</body>
</html>

	
