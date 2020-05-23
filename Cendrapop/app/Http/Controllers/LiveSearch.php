<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use UsersController;

class LiveSearch extends Controller
{
    //Funcio per tornar la vista
    function index(){
     return view('live_search');
    }

    //Funcio AYAX per buscar ho que fico a l'input, imprimeixo la taula des d'alla
    function action(Request $request){
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('users')
         ->where('id', 'like', '%'.$query.'%')
         ->orWhere('name', 'like', '%'.$query.'%')
         ->orWhere('email', 'like', '%'.$query.'%')
         ->orWhere('role', 'like', '%'.$query.'%')
         ->orderBy('id', 'asc')
         ->get();
         
      }
      else
      {
       $data = DB::table('users')
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
         <td>'.$row->name.'</td>
         <td>'.$row->email.'</td>
         <td>'.$row->role.'</td>
       
         <!--<td>
         <form action="/profile/dropadmin/'.$row->id.'" metho="POST">
                <button type="submit" class="btn btn-danger" style="display:inline">
         </form>




              <a class="btn btn-info" href="profile/edit/'.$row->id.'"><i class="fas fa-trash"></i> Editar</a>

         </td>-->



        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">Cap usuari amb aquest nom</td>
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
