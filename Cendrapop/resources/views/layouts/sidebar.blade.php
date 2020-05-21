<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right col-md-2" id="sidebar-wrapper">
      <div class="sidebar-heading">
        <img src="{{url('/logo/logo_transparent.png')}}" class="img-fluid">
      </div>
            <span class="subtitle">Benvingut:<b> {{ Auth::user()->name }}</b></span>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-light"><i class="far fa-user"></i>Perfil</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Shortcuts</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>
      </div>
    </div>