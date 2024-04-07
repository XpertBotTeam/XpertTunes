<?php

namespace App\Http\Controllers\API;

use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlaylistRequest;

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

}
