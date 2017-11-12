<?php

namespace App\Http\Controllers;

use App\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['apiArtists', 'apiArtist']]);
    }

    public function index()
    {
        return view('artists');
    }

    public function store(Request $request)
    {
        $root = 'http://' . $_SERVER['SERVER_NAME'] . ':89/moledcontrol';
        $this->validate($request, [
           'artist_name' => 'required'
        ]);
        $artist = Artist::where('artist_name', $request->artist_name)->get();

        if ($artist->count()){
            return redirect()->back()->withErrors('Artist already exists');
        }

        if ($request->hasFile('img_url')) {
            $file = $request->file('img_url');
			
			// Defining file name
            $last_record = Artist::orderBy('id', 'desc')->first();
            $new_id = $last_record->id + 1;
            $filename = 'artist_' . $new_id . '.' . $file->getClientOriginalExtension();
			
            $destinationPath = 'img/artist';
            $file->move($destinationPath, $filename);
            $uri = $root . '/' .$destinationPath . '/' . $filename;

            $artist = new Artist;
            $artist->artist_name = $request->input('artist_name');
            $artist->img_url     = $uri;

            $artist->save();

            session()->flash('message', 'Artist has been added successfully.');
            return redirect()->back();
        }
    }

    public function artistList()
    {
        $artists = Artist::orderBy('id', 'desc')->paginate(20);
        return view('artistList', compact('artists'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $artists = Artist::where('artist_name', 'like', "%$search%")->get();

        return view('artistSearchList', compact('artists'));
    }

    public function newArtist()
    {
        return view('artist');
    }

    public function delete($id)
    {
        $artist = Artist::find($id);

        foreach($artist->tracks as $track){
            $track->delete();
        }

        foreach($artist->albums as $album){
            $album->delete();
        }

        $artist->delete();

        return redirect()->route('artists');
    }

    public function editArtist($id)
    {
        $artist = Artist::find($id);

        return view('editArtist', compact('artist'));
    }

    public function update(Request $request)
    {

        $artist = Artist::find($request->id);
        $artist->artist_name = $request->artist_name;
        if ($request->hasFile('img_url')){
            $root = 'http://' . $_SERVER['SERVER_NAME'] . ':89/moledcontrol';
            $file = $request->file('img_url');
			
			$filename = 'artist_' . $artist->id . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'img/artist';
            $file->move($destinationPath, $filename);
            $uri = $root . '/' .$destinationPath . '/' . $filename;

            $artist->img_url = $uri;
        }
        $artist->save();

        session()->flash('message', 'Artist has been updated');
        return redirect()->back();
    }

    public function artistAlbums(Request $request)
    {

        $artist = Artist::find($request->id);
        $albums = $artist->albums;
        return view('artistAlbumsList', compact('albums'));
    }

    /* Api methods */

    public function apiArtists()
    {
        return Artist::all();
    }

    public function apiArtist(Artist $artist)
    {
        return $artist;
    }

}

