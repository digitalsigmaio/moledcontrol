<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {return $request->user(); });

/* Artist api */

Route::get('/artists', 'ArtistController@apiArtists'); //retrieve all artists

Route::get('/artist/{artist}', 'ArtistController@apiArtist'); //retrieve artist by id

/* Album api */

Route::get('/albums/{artist_id}', 'AlbumController@apiAlbumByArtist'); //retrieve album by artist id

/* Track api */

Route::get('/tracks', 'TrackController@apiTracks');  //retrieve all tracks

Route::get('/tracksByArtist/{artist_id}', 'TrackController@apiTracksByArtist'); //retrieve tracks by artist id

Route::get('/tracksByAlbum/{album_id}', 'TrackController@apiTracksByAlbum'); //retrieve tracks by album id

Route::post('/tracksSearch', 'TrackController@apiTracksSearch'); //search tracks by track name