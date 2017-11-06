@extends('layouts.master')

@section('content')
	<div class="row">
        <div class="col-md-6 col-md-offset-3 content-insert">
            <form action='notification' method='post'>
                <div class="form-group">
                    <label for="link_url">Link</label>
                    <input type="text" class="form-control" id="link_url" name="link_url" placeholder="Put your link">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info">Send</button>
                </div>
            </form>
        </div>

    </div> 
@endsection