@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3 content-insert">
            <div class="row button-area">
                <ul class="nav navbar-nav">
                    <li><a href="albumList" class="btn btn-info">List</a></li>
                    <li><a href="album" class="btn btn-primary">New Album</a></li>
                </ul>
            </div>
            <div id="row" class="search-area">
                <div class="input-group">
                    <span class="input-group-addon">
                        <select name="category" id="category">
                            <option value="0">Artist</option>
                            <option value="1">Album</option>
                        </select>
                    </span>
                    <input type="search" class="form-control"  placeholder="Search by artist" id="albumSearch">
                </div>
            </div>
        </div>
    </div>
    <div class="row album-details" id="list">
        @if(count($albums) > 0)
        <hr>
        <table class="table table-striped table-hover ">
            <thead>
            <tr>
                <th>ID</th>
                <th>Album Name</th>
                <th>Artist</th>
                <th>Image</th>
                <th>Edit</th>
                <th>x</th>
            </tr>
            </thead>
            <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>{{ $album->album_id }}</td>
                    <td>{{ $album->album_name }}</td>
                    <td>{{ $album->artist->artist_name }}</td>
                    <td><div class="img" style="background-image: url('{{ $album->img_url }}');"></div></td>
                    <td><a href="album/{{ $album->album_id }}" class="btn btn-default">Edit</a></td>
                    <td><a href="album/{{ $album->album_id }}/delete" class="btn btn-danger deleteItem">Delete</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
		{{ $albums->links() }}
        @else
            <h4>Their is no Album in the record yet</h4>
        @endif
    </div>
@endsection