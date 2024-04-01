<?php

use App\Http\Controllers\API\ArtistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;


Route::post('/login', [UserController::class,'login']);
Route::post('/register', [UserController::class,'register']);

Route::resource('artists',ArtistController::class);



// setting route group
Route::group(['middleware'=>['auth:sanctum']],function(){

});

