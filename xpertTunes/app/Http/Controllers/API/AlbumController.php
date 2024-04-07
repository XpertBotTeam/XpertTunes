<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumRequest;
use Illuminate\Http\Request;
use App\Models\Album;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::all();
        return response()->json([
            'status'=>true,
            'data' => $albums,
            'message' => 'All Albums returned successfully'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AlbumRequest $request)
    {
        $album=Album::create($request->all());
        return response()->json([
            'status'=>true,
            'data'=>$album,
            'message'=>'Album created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $album = Album::find($id);
        if(!is_null($album))
        {
            return response()->json([
                'status'=>true,
                'data'=>$album,
                'message'=>'Album data returned successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>'Album data not found'
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(AlbumRequest $request, string $id)
    {
        $album = Album::find($id);
        if(!is_null($album))
        {
            $album->update($request->all());
            return response()->json([
                'status'=>true,
                'data'=>$album,
                'message'=>'Album data updated successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>'Album data not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $album = Album::find($id);
        if(!is_null($album))
        {
            $album->delete();
            return response()->json([
                'status'=>true,
                'data'=>null,
                'message'=>'album deleted successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>'album not found'
            ]);
        }
    }

    public function songs($id, Request $request)
    {
        $album = Album::find($id);
        if(!is_null($album))
        {
            $songs = $album->songs;
            return response()->json([
                'status'=>true,
                'data'=>$songs,
                'message'=>'Songs of Specific Album'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>'Album not Found'
            ]);
        }
    }
}
