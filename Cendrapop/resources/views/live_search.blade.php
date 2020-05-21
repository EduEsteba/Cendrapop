@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
  <div class="container box">
  <br>
   <h3 align="center">Llista d'usuaris</h3><br />
   <div class="panel panel-default">
    <div class="panel-heading">Introdueix el nom d'usuari:</div>
    <div class="panel-body">
     <div class="form-group">
      <input type="text" name="search" id="search" class="form-control" placeholder="Usuari" />
     </div>
     <div class="table-responsive">
      <h3 align="center">Usuaris totals : <span id="total_records"></span></h3>
      <a class="btn btn-primary" href="{{ route('json') }}"><i class="fas fa-download"></i> JSON</a>
      <a class="btn btn-primary" href="{{ route('usuaris.xml') }}"><i class="fas fa-download"></i> XML</a>
      <br>
      <br>


      <table class="table table-striped table-bordered" style="text-align: center">
       <thead>
        <tr>
         <th>ID</th>
         <th>Nom</th>
         <th>E-Mail</th>
         <th>Rol</th>
        </tr>
       </thead>
       <tbody>

       </tbody>
      </table>
     </div>
    </div>    
   </div>
  </div>


<script>
$(document).ready(function(){

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ route('live_search.action') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>
@endsection