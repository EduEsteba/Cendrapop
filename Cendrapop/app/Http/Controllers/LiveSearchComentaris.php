<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LiveSearchComentaris extends Controller
{
    
    function index()
    {
     return view('live_search_comentaris');
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('messages')
         ->where('id', 'like', '%'.$query.'%')
         ->orWhere('content', 'like', '%'.$query.'%')
         ->orderBy('id', 'asc')
         ->get();
         
      }
      else
      {
       $data = DB::table('messages')
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
         <td>'.$row->user_id.'</td>
         <td>'.$row->product_id.'</td>
         <td>'.$row->content.'</td>
         <td><a href="/delete/'.$row->id.'">Eliminar</a></td>
       

        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">Cap comentari</td>
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
