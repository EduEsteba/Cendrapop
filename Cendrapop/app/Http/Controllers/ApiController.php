<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Message;

class ApiController extends Controller
{
    public function indexUsers(){
        return response()->json(User::all());
    }

    public function indexProducts(){
        return response()->json(Message::all());
    }

    public function indexComentaris(){
        return response()->json(Message::all());
    }
}
