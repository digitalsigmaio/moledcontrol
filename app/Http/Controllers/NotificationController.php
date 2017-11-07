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
	
	public function linkForm()
	{
		return view('notificationLink');
	}

    public function notifyLink(Request $request)
    {
        $this->validate($request, [
            'link_url' => 'required',
        ]);

        $notification = $request->link_url;
        $message = [
            'url' => $notification,
            'role' => 'link'
        ];
        self::notify($message);
    }

    public function boxForm()
    {
        return view('notificationBox');
    }

    public function notifyBox(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required',
            'link'  => 'required'
        ]);

        switch($request->icon){
            case 0:
                $img = Notification::MOLEDAPP_ICON;
                break;
            case 1:
                $img = Notification::YOUTUBE_ICON;
                break;
            case 2:
                $img = $request->custom_icon;
                break;
            default:
                return false;
        }
        $message = [
            'title'     => $request->title,
            'message'   => $request->body,
            'img'       => $img,
            'url'       => $request->link,
            'role'      => '1'
        ];
        self::notify($message);
    }

	public static function notify($message)
	{

		
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
			$response_array = [];
		    $response_array['success']= $ticket_array->success;
			$response_array['failure']= $ticket_array->failure;
			$response[] = $response_array;
		}

		
		Log::useDailyFiles(storage_path().'/logs/notification.log');
		Log::info(['Response'=>$response]);
		$response_total = Notification::response_total($response);
		session()->flash('message', 'Notification has been sent check notification.log on your logs folder for more information');
		session()->flash('log', $response_total);
		return redirect()->back();
	}
}
