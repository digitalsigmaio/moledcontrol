@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="row">
			<div class="col-md-6 col-md-offset-3 content-insert">
				<form action='notificationBox' method='post'>
				{{ csrf_field() }}
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
					</div>
					<div class="form-group">
						<label for="body">Body</label>
						<textarea name="body" id="body" cols="30" rows="10" class="form-control" placeholder="Body" required></textarea>
					</div>
					<div class="form-group">
						<label for="icon">Icon</label>
						<select name="icon" id="icon" class="form-control">
							<option value="0">MoledApp</option>
							<option value="1">YouTube</option>
							<option value="2">Custom</option>
						</select>
						<input type="text" class="form-control" name="custom_icon" id="custom_icon" placeholder="URL" style="display: none; position: relative; top: 10px;">
					</div>
					<div class="form-group">
						<label for="link">Link</label>
						<input type="text" class="form-control" id="link" name="link" placeholder="URL" required>
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