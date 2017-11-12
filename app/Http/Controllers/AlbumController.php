<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Album;
use App\Track;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['apiAlbumByArtist']]);
    }

    public function index()
    {
        return view('albums');
    }

    public function store(Request $request)
    {
		$root = 'http://' . $_SERVER['SERVER_NAME'] . ':89/moledcontrol';
        $this->validate($request, [
            'album_name' => 'required'
        ]);

        $album = Album::where('album_name', $request->album_name)->get();

        if ($album->count()){
            return redirect()->back()->withErrors('Album already exists');
        }

        if ($request->hasFile('img_url')) {
            //
            $file = $request->file('img_url');
			
			$last_record = Album::orderBy('album_id', 'desc')->first();
            $new_id = $last_record->id + 1;
            $filename = 'album_' . $new_id . '.' . $file->getClientOriginalExtension();
			
            $destinationPath = 'img/album';
            $file->move($destinationPath, $filename);
            $uri = $root . '/' . $destinationPath . '/' . $filename;

            $album = new Album;
            $album->album_name = $request->input('album_name');
            $album->artist_id = $request->input('artist_id');
            $album->img_url     = $uri;

            $album->save();

            session()->flash('message', 'Album has been added successfully.');
            return redirect()->back();
        }
    }

    public function albumList()
    {
        $albums = Album::orderBy('album_id', 'desc')->paginate(20);
        return view('albumList', compact('albums'));
    }

    public function search(Request $request)
    {
        $category = $request->category;
        $search = $request->search;
        switch ($category){
            case 0:
                $artist = Artist::where('artist_name', 'like', "%$search%")->first();
                $albums = Album::where('artist_id', $artist->id)->get();
                return view('albumSearchList', compact('albums'));
            case 1:
                $albums = Album::where('album_name', 'like', "%$search%")->get();

                return view('albumSearchList', compact('albums'));
            default:
                return false;
        }
    }

    public function newAlbum()
    {
        $artists = Artist::all();
        return view('album', compact('artists'));
    }

    public function delete($id)
    {
        $album = Album::find($id);


        $tracks = Track::where('album_id', $album->album_id);
        foreach($tracks as $track){
            $track->delete();
        }

        $album->delete();

        return redirect()->route('albums');
    }

    public function editAlbum($id)
    {
        $album = Album::find($id);
        $artists = Artist::all();
        return view('editAlbum', compact(['album', 'artists']));
    }

    public function update(Request $request)
    {
		$root = 'http://' . $_SERVER['SERVER_NAME'] . ':89/moledcontrol';
        $album = Album::find($request->album_id);
        $album->album_name = $request->album_name;
        if ($request->hasFile('img_url')){
            $file = $request->file('img_url');
			
			$filename = 'album_' . $album->album_id . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'img/album';
            $file->move($destinationPath, $filename);
            $uri = $root . '/' . $destinationPath . '/' . $filename;

            $album->img_url = $uri;
        }
        $album->artist_id = $request->artist_id;
        $album->save();

        session()->flash('message', 'Album has been updated');
        return redirect()->back();
    }

    /* Api methods */

    public function apiAlbumByArtist($artist_id)
    {
        return Album::where('artist_id', $artist_id)->get();
    }
}
