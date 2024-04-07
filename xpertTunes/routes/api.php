<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AlbumController;
use App\Http\Controllers\API\ArtistController;
use App\Http\Controllers\API\PlaylistController;
use App\Http\Controllers\API\SongController;

Route::post('/login', [UserController::class,'login']);
Route::post('/register', [UserController::class,'register']);

Route::resource('artists',ArtistController::class);

Route::resource('albums',AlbumController::class);
Route::get('/artists/{id}/albums',[ArtistController::class,'albums']);

Route::resource('songs',SongController::class);
Route::get('/albums/{id}/songs',[AlbumController::class,'songs']);


// setting route group
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::resource('playlists',PlaylistController::class);
    Route::get('/users/{id}/playlists',[UserController::class,'playlists']);
});

