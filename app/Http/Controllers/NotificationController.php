<?php

namespace App\Http\Controllers;

use App\Token;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function index()
	{
		return view('notification');
	}


	public function notify(Request $request)
	{
		$this->validate($request, [
			'link_url' => 'required',
		]);
		
		$notification = $request->link_url;
		$message = [
			'url' => $notification,
			'role' => 'link'
		];
		
		$tokens_data = Token::all();
		$tokens = [];
		foreach($tokens_data as $token){
			$tokens[] = $token->tokens;
		}
		

		$tokens_chunk = array_chunk($tokens, 500);
		$response = [];
		foreach($tokens_chunk as $group){
		    $ticket = Notification::push($group, $message);
		    $ticket_array = json_decode($ticket);
		    $response_array = array_splice($ticket_array, 0, 3);

			$response[] = $response_array;
		}

		
		Log::useDailyFiles(storage_path().'/logs/notification.log');
		Log::info(['Response'=>$response]);
		$response_total = Notification::response_total($response);
		session()->flash('message', "Notification has been sent check notification.log on your logs folder for more information.<br> {$response_total}");
		return redirect()->back();
	}
}
