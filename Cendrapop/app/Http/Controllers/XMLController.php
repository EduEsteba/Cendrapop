<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\User;
use App\Product;
use App\Message;

class XMLController extends Controller 
{
    	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function download(){
        $users = User::all();
	    $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument();
        $xml->startElement('Usuaris');
            foreach($users as $user) {
                $xml->startElement('user');
                $xml->writeElement('id', $user->id);
                $xml->writeElement('name', $user->name);
                $xml->writeElement('email', $user->email);
                $xml->writeElement('role', $user->role);
                $xml->writeElement('password', $user->password);
                $xml->endElement();
            }

        $xml->endElement();
	    $xml->endDocument();
	    $filename = now()->format('Y-m-d-H-i-s');
        header("Content-Type: text/html/force-download");
        header("Content-Disposition: attachment; filename=".$filename.".xml");


    $content = $xml->outputMemory();
	$xml = null;

    return response($content)->header('Content-Type', 'text/xml');
    }



    public function download_products(){
        $products = Product::all();
	    $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument();
        $xml->startElement('Productes');
            foreach($products as $product) {
                $xml->startElement('Producte');
                $xml->writeElement('id', $product->id);
                $xml->writeElement('created_at', $product->created_at);        
                $xml->writeElement('deleted_at', $product->deleted_at);
                $xml->writeElement('title', $product->title);
                $xml->writeElement('description', $product->description);
                $xml->writeElement('price', $product->price);
                $xml->writeElement('user_id', $product->user_id);
                $xml->writeElement('category_id', $product->category_id);
                $xml->endElement();
            }

        $xml->endElement();
	    $xml->endDocument();
	    $filename = now()->format('Y-m-d-H-i-s');
        header("Content-Type: text/html/force-download");
        header("Content-Disposition: attachment; filename=".$filename.".xml");


    $content = $xml->outputMemory();
	$xml = null;

    return response($content)->header('Content-Type', 'text/xml');
    }

    public function download_comentaris(){
        $products = Message::all();
	    $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument();
        $xml->startElement('Missatges');
            foreach($products as $product) {
                $xml->startElement('Missatge');
                $xml->writeElement('id', $product->id);
                $xml->writeElement('created_at', $product->created_at);        
                $xml->writeElement('updated_at', $product->updated_at);
                $xml->writeElement('user_id', $product->user_id);
                $xml->writeElement('product_id', $product->product_id);
                $xml->writeElement('contingut', $product->content);
                $xml->endElement();
            }

        $xml->endElement();
	    $xml->endDocument();
	    $filename = now()->format('Y-m-d-H-i-s');
        header("Content-Type: text/html/force-download");
        header("Content-Disposition: attachment; filename=".$filename.".xml");


    $content = $xml->outputMemory();
	$xml = null;

    return response($content)->header('Content-Type', 'text/xml');
    }
}
