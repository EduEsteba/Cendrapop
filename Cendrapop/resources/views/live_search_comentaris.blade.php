@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
  <div class="container box">
  <br>
   <h3 align="center">Llistat de comentaris</h3><br />
   <div class="panel panel-default">
    <div class="panel-heading">Introdueix el contingut del comentari:</div>
    <div class="panel-body">
     <div class="form-group">
      <input type="text" name="searchproducte" id="searchproducte" class="form-control" placeholder="Comentari" />
     </div>
     <div class="table-responsive">
      <h3 align="center">Productes totals : <span id="total_records"></span></h3>
      <a class="btn btn-primary" href="{{ route('comentaris_json') }}"><i class="fas fa-download"></i> JSON</a>
      <a class="btn btn-primary" href="{{ route('comentarisapi') }}"><i class="fas fa-info-circle"></i> API JSON</a>
      <a class="btn btn-primary" href="{{ route('comentaris_xml') }}"><i class="fas fa-download"></i> XML</a>
      <br>
      <br>
      <table class="table table-striped table-bordered" style="text-align: center">
       <thead>
        <tr>
         <th>ID</th>
         <th>USER ID</th>
         <th>PRODUCT ID</th>
         <th>CONTINGUT</th>
         <th>ACCIONS</th>
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
   url:"{{ route('live_search_comentaris.action') }}",
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

 $(document).on('keyup', '#searchproducte', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>
@endsection