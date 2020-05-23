<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Message;
use Illuminate\Http\Request;

class JsonGenerateController extends Controller{

    //3 Funcions per mostrar 3 taules en format json

    public function json(){
        $posts = User::orderBy('id')->get();

        $data = [
            'version' => 'https://jsonfeed.org/version/1',
            'title' => 'Laravel News Feed',
            'home_page_url' => 'https://laravel-news.com/',
            'feed_url' => 'https://laravel-news.com/feed/json',
            'icon' => 'https://laravel-news.com/apple-touch-icon.png',
            'favicon' => 'https://laravel-news.com/apple-touch-icon.png',
            'items' => [],
        ];

        foreach ($posts as $key => $post) {
            $data['items'][$key] = [
                'id' => $post->id,
                'nom' => $post->name,
                'email' =>$post->email,
                'rol' =>$post->role,
                'password' =>$post->password,
            ];
        }
        $filename = now()->format('Y-m-d-H-i-s');
        //"Forço" a que es descarregui
        header("Content-Type: text/html/force-download");
        header("Content-Disposition: attachment; filename=".$filename.".json");
        return $data;

    }

    public function jsonProducts(){
        $posts = Product::orderBy('id')->get();

        $data = [
            'version' => 'https://jsonfeed.org/version/1',
            'title' => 'Laravel News Feed',
            'home_page_url' => 'https://laravel-news.com/',
            'feed_url' => 'https://laravel-news.com/feed/json',
            'icon' => 'https://laravel-news.com/apple-touch-icon.png',
            'favicon' => 'https://laravel-news.com/apple-touch-icon.png',
            'items' => [],
        ];

        foreach ($posts as $key => $post) {
            $data['items'][$key] = [
                'id' => $post->id,
                'created_at' => $post->created_at,
                'deleted_at' =>$post->deleted_at,
                'title' =>$post->title,
                'description' =>$post->description,
                'price' =>$post->price,
                'user_id' =>$post->user_id,
                'category_id' =>$post->category_id,
            ];
        }
        $filename = now()->format('Y-m-d-H-i-s');
        header("Content-Type: text/html/force-download");
        header("Content-Disposition: attachment; filename=".$filename.".json");
        return $data;

    }

    public function jsonComentaris(){
        $posts = Message::orderBy('id')->get();

        $data = [
            'version' => 'https://jsonfeed.org/version/1',
            'title' => 'Laravel News Feed',
            'home_page_url' => 'https://laravel-news.com/',
            'feed_url' => 'https://laravel-news.com/feed/json',
            'icon' => 'https://laravel-news.com/apple-touch-icon.png',
            'favicon' => 'https://laravel-news.com/apple-touch-icon.png',
            'items' => [],
        ];

        foreach ($posts as $key => $post) {
            $data['items'][$key] = [
                'id' => $post->id,
                'created_at' => $post->created_at,
                'updated_at' =>$post->updated_at,
                'usuari_id' =>$post->user_id,
                'product_id' =>$post->product_id,
                'contingut' =>$post->content,
            ];
        }
        $filename = now()->format('Y-m-d-H-i-s');
        header("Content-Type: text/html/force-download");
        header("Content-Disposition: attachment; filename=".$filename.".json");
        return $data;

    }
}
