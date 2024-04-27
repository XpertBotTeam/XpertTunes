<?php

namespace App\Http\Controllers\API;

use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlaylistRequest;
use App\Http\Requests\PlaylistSongRequest;
use App\Models\Song;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = Playlist::all();
        return response()->json([
            'status' => true,
            'data' => $playlists,
            'message' => 'lists of Playlists'

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlaylistRequest $request)
    {
        $user=auth()->user();
        if($user->id == $request->get('user_id'))
        {
            $playlist=Playlist::create($request->all());
            return response()->json([
                'status' => true,
                'data' => $playlist,
                'massage' => 'Playlist Created Successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'data' => null,
                'massage' => 'User is not authenticated'
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $playlist = Playlist::find($id);
        if(!is_null($playlist)){
            return response()->json([
                'status' => true,
                'data' => $playlist,
                'massage' => 'Playlist data returned successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'data' => null,
                'massage' => 'playlist data not Found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlaylistRequest $request, string $id)
    {
        /* $playlist = Playlist::find($id);
        $playlist = $playlist->update($request->all());
        return response()->json([
            'status' => true,
            'data' => $playlist,
            'massage' => 'Playlist Updated Succsessfully'
        ]); */

        $user=auth()->user();
        if($user->id == $request->get('user_id'))
        {
            $playlist = Playlist::find($id);
             if(!is_null($playlist))
             {
                $playlist->update($request->all());
                return response()->json([
                  'status' => true,
                  'data' => $playlist,
                  'massage' => 'Playlist data returned successfully'
                 ]);
             }
             else{
                   return response()->json([
                     'status' => false,
                     'data' => null,
                     'massage' => 'playlist data not Found'
                 ]);
                 }
        }else{
            return response()->json([
                'status' => false,
                'data' => null,
                'massage' => 'User is not authenticated'
            ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = Playlist::destroy($id);
        if($result)
        {
            return response()->json([
                'status' => true,
                'data' => null,
                'message' => 'Playlist Deleted Successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Playlist not Found'
            ]);
        }
    }

    public function addSongToPlaylist(PlaylistSongRequest $request)
{
    try {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User is not authenticated'
            ], 401);
        }

        $playlistId = $request->input('playlist_id');
        $songId = $request->input('song_id');

        $playlist = Playlist::where('user_id', $user->id)->findOrFail($playlistId);
        $song = Song::findOrFail($songId);

        if ($playlist->songs()->where('song_id', $songId)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Song already exists in the playlist'
            ], 422);
        }

        $playlist->songs()->attach($songId);

        return response()->json([
            'status' => true,
            'message' => 'Song added to playlist successfully'
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        if ($e->getModel() == Playlist::class) {
            return response()->json([
                'status' => false,
                'message' => 'Playlist not found'
            ], 404);
        } elseif ($e->getModel() == Song::class) {
            return response()->json([
                'status' => false,
                'message' => 'Song not found'
            ], 404);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


    public function songs($id)
    {
        $playlist = Playlist::find($id);
        if(!is_null($playlist))
        {
            $songs = $playlist->songs;
            return response()->json([
                'status'=>true,
                'data'=>$playlist,
                'message'=>'Songs for Specific playlist'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>'playlist not Found'
            ]);
        }
    }


    public function removeSongFromPlaylist($playlistId, $songId)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User is not authenticated'
        ], 401);
    }

    $playlist = Playlist::where('user_id', $user->id)->find($playlistId);

    if (is_null($playlist)) {
        return response()->json([
            'status' => false,
            'message' => 'Playlist not found'
        ], 404);
    }

    $song = $playlist->songs()->where('song_id', $songId)->first();

    if (is_null($song)) {
        return response()->json([
            'status' => false,
            'message' => 'Song does not exist in the playlist'
        ]);
    }

    $playlist->songs()->detach($songId);

    return response()->json([
        'status' => true,
        'message' => 'Song removed from playlist successfully'
    ]);
}

}


