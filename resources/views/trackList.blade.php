@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3 content-insert">
            <div class="row button-area">
                <ul class="nav navbar-nav">
                    <li><a href="trackList" class="btn btn-info">List</a></li>
                    <li><a href="track" class="btn btn-primary">New Track</a></li>
                </ul>
            </div>
            <div id="row" class="search-area">
                <div class="input-group">
                    <span class="input-group-addon">
                        <select name="category" id="category">
                            <option value="0">Artist</option>
                            <option value="1">Album</option>
                            <option value="2">Track</option>
                        </select>
                    </span>
                    <input type="search" class="form-control"  placeholder="Search by artist" id="trackSearch">
                </div>
            </div>
        </div>
    </div>
    <div class="row track-details" id="list">
        @if(count($tracks) > 0)
        <hr>
        <table class="table table-striped table-hover ">
            <thead>
            <tr>
                <th>ID</th>
                <th>Artist</th>
                <th>Album</th>
                <th>Track Name</th>
                <th>Track</th>
                <th>Vodafone</th>
                <th>Orange</th>
                <th>Etisalat</th>
                <th>Image</th>
                <th>Ringtone</th>

                <th>Edit</th>
                <th>x</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tracks as $track)
                <tr>
                    <td>{{ $track->id }}</td>
                    <td>{{ $track->artist_name }}</td>
                    @php
                        $album = \App\Album::find($track->album_id);
                    @endphp
                    <td>{{ $album->album_name }}</td>
                    <td>{{ $track->track_name }}</td>
                    <td>
                        <div id="player">
                            <span class="glyphicon glyphicon-play play"></span>
                            <span class="glyphicon glyphicon-pause pause" style="display: none"></span>
                            <audio class="player" src="{{ $track->track_url }}" type="audio/mpeg"></audio>
                        </div>

                    </td>
                    <td>{{ $track->vod }}</td>
                    <td>{{ $track->orang }}</td>
                    <td>{{ $track->etis }}</td>
                    <td><div class="img track-img" style="background-image: url('{{ $track->img_url == '' ? 'img/default.jpg' : $track->img_url }}');"></div></td>
                    <td>
                        @if($track->ringtone_url != null)
                            <div id="player">
                                <span class="glyphicon glyphicon-play play"></span>
                                <span class="glyphicon glyphicon-pause pause" style="display: none"></span>
                                <audio class="player" src="{{ $track->ringtone_url }}" type="audio/mpeg"></audio>
                            </div>
                        @else
                            There is no associated ringtone for this track.
                        @endif
                    </td>
                    <td><a href="track/{{ $track->id }}" class="btn btn-default">Edit</a></td>
                    <td><a href="track/{{ $track->id }}/delete" class="btn btn-danger deleteItem">Delete</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
		
		{{ $tracks->links() }}
        @else
            <h4>There is no Track in the record yet</h4>
        @endif
    </div>
@endsection