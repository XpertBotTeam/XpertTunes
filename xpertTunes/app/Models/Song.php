<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'track',
        'genre',
        'release_date',
    ];


    public function album(){
        return $this->belongsTo(Album::class);
    }

    public function artists(){
        return $this->belongsToMany(Artist::class);
    }

    public function playlists(){
        return $this->belongsToMany(Playlist::class);
    }
}
