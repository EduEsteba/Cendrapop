<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\User;

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
}
