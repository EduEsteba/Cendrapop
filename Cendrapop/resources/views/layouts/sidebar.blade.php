
<div class="d-flex" >
    <div class="bg-light border-right col-md-2" >
      <div class="sidebar-heading">
      <a class="navbar-brand" href="{{ url('/') }}">        <img src="{{url('/logo/logo_transparent.png')}}" class="img-fluid">
</a>
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
    <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action bg-light"><i class="far fa-user"></i> Perfil</a>
    <a href="{{ route('products.add') }}" class="list-group-item list-group-item-action bg-light"><i class="fas fa-plus"></i> Nou Producte</a>
    
    @if ( Auth::user()->role == 'admin' )
  <a class="list-group-item list-group-item-action bg-light" href="{{ route('categories.show') }}"><i class="far fa-edit"></i> Editar categories</a>
  <a class="list-group-item list-group-item-action bg-light"href="{{ route('live_search') }}"><i class="fas fa-users"></i> Control d'usuaris</a>
  <a class="list-group-item list-group-item-action bg-light" href="{{ route('live_search_products') }}"><i class="fas fa-book-open"></i> Control Productes</a>
  <a class="list-group-item list-group-item-action bg-light" href="{{ route('live_search_comentaris') }}"><i class="fas fa-comments"></i> </i> Comentaris</a>

@endif
      
         

      </div>
    </div>