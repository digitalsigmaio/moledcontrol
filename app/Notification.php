<?php

namespace App;

use App\Token;
use Illuminate\Database\Eloquent\Model;

class Notification
{
    const API_KEY = 'Authorization:key = AIzaSyA64wlqh9py1DvVOj6N3Rd52uN1CfJtJos';
	const URL = "https://fcm.googleapis.com/fcm/send";
	protected static $headers = [ self::API_KEY, 'Content-Type: application/json' ];
	
	public static function push($tokens, $message)
	{
		$fields = [
        'registration_ids' => $tokens,
        'data' => $message
		];
		if (count($tokens) > 0 && $message != '') {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, self::URL);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, self::$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$result = curl_exec($ch);
			if ($result === FALSE) {
				die('Curl failed: ' . curl_error($ch));
			}
			curl_close($ch);
			return $result;
		}	
	}

	public static function response_total($response){
	    $success = 0;
	    $failure = 0;
		
	    foreach ($response as $item){
	        $success += $item['success'];
	        $failure += $item['failure'];
        }
		$device_num = $success + $failure;
		$request_num = count($response);
        return 'Total devices: ' . $device_num . ', Total request: ' . $request_num . ', Total success: ' . $success . ', Total failure: ' . $failure;
    }
}
