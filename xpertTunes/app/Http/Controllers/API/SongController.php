<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Http\Requests\SongRequest;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::all();
        return response()->json([
            'status'=>true,
            'data'=>$songs,
            'message'=>"all songs returned successfully"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SongRequest $request)
    {
        $song = Song::create($request->all());
        return response()->json([
            'status'=>true,
            'data'=>$song,
            'message'=>'Song Created Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $song = Song::find($id);
        if(!is_null($song))
        {
            return response()->json([
                'status'=>true,
                'data'=>$song,
                'message'=>'Song data returned successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>'Song data not found'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $song = Song::find($id);
        if(!is_null($song))
        {
            $song->update($request->all());
            return response()->json([
                'status'=>true,
                'data'=>$song,
                'message'=>'Song data updated successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>'Song data not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $song = Song::find($id);
        if(!is_null($song))
        {
            $song->delete();
            return response()->json([
                'status'=>true,
                'data'=>null,
                'message'=>"Song deleted successfully"
            ]);
        }
        else
        {
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>"Song not found"
            ]);
        }
    }
}
