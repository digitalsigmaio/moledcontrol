@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="row">
			<div class="col-md-6 col-md-offset-3 content-insert">
				<form action='notificationLink' method='post'>
				{{ csrf_field() }}
					<div class="form-group">
						<label for="link_url">Link</label>
						<input type="text" class="form-control" id="link_url" name="link_url" placeholder="Put your link" required>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-info">Send</button>
					</div>
				</form>
			</div>
		</div>
		@if(count($errors) > 0)
            <div class="row">
                <div class="col-md-6 col-md-offset-3 alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
		@if(session()->get('message'))
            <div class="row">
				<div class="col-md-6 col-md-offset-3 alert alert-dismissible alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>{{ session()->get('message') }}</strong>.
				</div>
            </div>
		@endif
		@if(session()->get('log'))
            <div class="row">
				<div class="col-md-6 col-md-offset-3 alert alert-dismissible alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>{{ session()->get('log') }}</strong>.
				</div>
            </div>
		@endif
    </div> 
@endsection