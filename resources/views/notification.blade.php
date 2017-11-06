@extends('layouts.master')

@section('content')
	<div class="row">
        <form action='PushNotificationServiceBrowser.php' method='POST'>
			 link url <textarea name='link_url'></textarea><br/><br/><br/>
            Submit<input type="submit" name="btn_upload_notify" value="Upload" ><br/>
        </form>
    </div> 
@endsection