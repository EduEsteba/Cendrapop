<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller {

	public function index() {

	}

	public function destroy($id){
  $missatge=Message::findOrFail($id);

  if ($missatge->delete()) {
      return redirect("/live_search_comentaris");
  }

  return 'Algo ha sortir malament';
}

	public function store(Request $request) {
		$data      = request()->input();
		$validator = validator()->make(
			$data, [
				     'content' => ['required'],
			     ]
		);

		if ($validator->passes()) {
			$message = new Message(
				[
					'content'    => request()->input('content'),
					'product_id' => request()->input('product_id'),
					'user_id'    => auth()->id(),
				]
			);
			$message->save();

			return back()->with('success', 'Message Saved Successfully!');
		}

		return redirect()->back()->withErrors($validator->errors())->withInput()->with('error', 'Problema al comentar!');
	}
}
