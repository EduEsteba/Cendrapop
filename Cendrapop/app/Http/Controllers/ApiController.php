<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;

class ApiController extends Controller
{
    public function indexUsers(){
        return response()->json(User::all());
    }

    public function indexProducts(){
        return response()->json(Product::all());
    }
}
