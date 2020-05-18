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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Cendrapop') }}
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="nav-item">

						<ul class="nav header-nav justify-content-end">
							@guest
								<li class="nav-item">
									<a class="nav-link text-black" href="{{ route('login') . '?previous=' . Request::fullUrl() }}">Login</a>
								</li>
								<li class="nav-item">
									@if (Route::has('register'))
										<a class="nav-link text-black" href="{{ route('register') }}">Register</a>
									@endif
								</li>
							@else
								<li class="nav-item dropdown">
								<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
									<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
									<li><a class="dropdown-item" href="{{ url('/profile') }}">Perfil</a></li>
									<li><a class="dropdown-item" href="{{ url('/products/new') }}">Nou producte</a></li>

										@if ( Auth::user()->role == 'admin' )
											<li><a class="dropdown-item" href="{{ route('categories.show') }}">Editar categories</a></li>
										@endif
										<li><a class="dropdown-item" href="{{ route('logout') }}"
										       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
												{{ __('Logout') }}
											</a>
											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
												@csrf
											</form>
										</li>
									</ul>
								</li>
							@endguest
						</ul>
					</div>
            </div>
        </nav>
	
        <main class="py-4">
            @yield('content')
        </main>

    </div>
	<script src="{{ asset('js/livesearch.js') }}"></script>

</body>
</html>
