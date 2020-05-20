<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class JsonGenerateController extends Controller
{
    public function json(){
        $posts = User::limit(20)->get();

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
        header("Content-Type: text/html/force-download");
        header("Content-Disposition: attachment; filename=".$filename.".json");
        return $data;

    }
}
