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
		
		/*
		$tokens = ['c1Y3asOooUk:APA91bE2qgOJs0MnQXvxuexPn1Ezm_8nHAlwFqnSimHXMF2c4QJAG5pvOpC64rTTO8gteIE8kmdy6JVHVjky6A-1ncVShhI1ayTIYY3wSqC7OoWYhlJLBOcQYq2CXwtrE8QkZCYeiIn3'];
		$notify = Notification::push($tokens, $message);
		dd($notify);
		*/
		$tokens_chunk = array_chunk($tokens, 500);
		$response = [];
		foreach($tokens_chunk as $group){
			$response[] = Notification::push($group, $message);		
		}
		
		Log::useDailyFiles(storage_path().'/logs/notification.log');
		Log::info(['Response'=>$response]);
		session()->flash('message', 'Notification has been sent check notification.log on your logs folder for more information.');
		return redirect()->back();
	}
}
