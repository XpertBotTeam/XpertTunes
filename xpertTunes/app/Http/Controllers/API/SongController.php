<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Http\Requests\SongRequest;
use Illuminate\Support\Facades\Storage;

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
        $track = $request->file('track');        
        $filePath = $track->store('tracks', 'public');
        $songData = $request->except('track'); 
        $songData['track'] = $filePath; 

        $song = Song::create($songData);
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
     * Update the specified resource in storage.
     */
    public function update(SongRequest $request, string $id)
{
    $song = Song::find($id);

    if (is_null($song)) {
        return response()->json([
            'status' => false,
            'data' => null,
            'message' => 'Song data not found'
        ]);
    }

    // Check if a new track file is being uploaded
    if ($request->hasFile('track')) {
        // Delete the old track file from storage
        Storage::disk('public')->delete($song->track);

        // Store the new track file
        $track = $request->file('track');
        $filePath = $track->store('tracks', 'public');

        // Update the track path in the song data
        $song->track = $filePath;
    }

    // Update other song data
    $song->title = $request->title;
    $song->genre = $request->genre;
    $song->release_date = $request->release_date;
    $song->album_id = $request->album_id;
    $song->artist_id = $request->artist_id;
    $song->save();

    return response()->json([
        'status' => true,
        'data' => $song,
        'message' => 'Song data updated successfully'
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $song = Song::find($id);
        if(!is_null($song))
        {
            Storage::disk('public')->delete($song->track);
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
