<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class LiveSearchProducts extends Controller
{
    function index()
    {
     return view('live_search_products');
    }

    function actionproducts(Request $request){
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('products')
         ->where('id', 'like', '%'.$query.'%')
         ->orWhere('title', 'like', '%'.$query.'%')
         ->orderBy('id', 'asc')
         ->get();
         
      }
      else
      {
       $data = DB::table('products')
         ->orderBy('id', 'asc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->id.'</td>
         <td>'.$row->title.'</td>
         <td>'.$row->description.'</td>
         <td>'.$row->price.'</td>
         <td>'.$row->deleted_at.'</td>

         <!--<td><a href="/deleteproducts/'.$row->id.' "class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</a></td>-->

        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">Cap producte amb aquest nom</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
}
