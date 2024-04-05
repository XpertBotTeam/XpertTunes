<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AlbumController;
use App\Http\Controllers\API\ArtistController;


Route::post('/login', [UserController::class,'login']);
Route::post('/register', [UserController::class,'register']);

Route::resource('artists',ArtistController::class);
Route::resource('albums',AlbumController::class);
Route::get('/artists/{id}/albums',[ArtistController::class,'albums']);

// setting route group
Route::group(['middleware'=>['auth:sanctum']],function(){

});

