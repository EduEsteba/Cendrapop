<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ApiController extends Controller
{
    public function indexUsers(){
        return response()->json(User::all());
    }
}
