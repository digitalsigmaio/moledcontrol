<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
	public function index()
	{
		return view('notification');
	}
	public function notify(Request $request)
	{
		$this->validate($request, [
			'link_url' => 'required',
		]);
		
		$notification = $requrest->link_url;
		$tokens_data = Token::all();
		$tokens = [];
		foreach($tokens_data as $token){
			$tokens[] = $token->tokens;
		}
		if(Notification::push($tokens, $notification){
			session()->flash('message', 'Notification has been sent');
			return redirect()->back();
		}
	}
}
