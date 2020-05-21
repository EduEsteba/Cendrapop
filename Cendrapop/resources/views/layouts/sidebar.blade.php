<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right col-md-2" id="sidebar-wrapper">
      <div class="sidebar-heading">
        <img src="{{url('/logo/logo_transparent.png')}}" class="img-fluid">
      </div>
            <span class="subtitle">Benvingut:  <b> {{ Auth::user()->name }}</b></span>
        
            
            <a href="{{ route('logout') }}"
										       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
						<i class="fas fa-sign-out-alt"></i>
											</a>
											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
												@csrf
											</form></a>
            
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-light"><i class="far fa-user"></i> Perfil</a>
        <a href="#" class="list-group-item list-group-item-action bg-light"><i class="fas fa-plus"></i> Nou Producte</a>
        
        @if ( Auth::user()->role == 'admin' )
			<a class="list-group-item list-group-item-action bg-light" href="{{ route('categories.show') }}"><i class="far fa-edit"></i> Editar categories</a>
			<a class="list-group-item list-group-item-action bg-light"href="{{ route('live_search') }}"><i class="fas fa-users"></i> Control d'usuaris</a>
			<a class="list-group-item list-group-item-action bg-light" href="{{ route('live_search_products') }}"><i class="fas fa-book-open"></i> Productes</a>
		@endif

      </div>
    </div>