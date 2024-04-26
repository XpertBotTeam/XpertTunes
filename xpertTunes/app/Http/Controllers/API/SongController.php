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
    // public function update(Request $request, string $id)
    // {
    //     $song = Song::find($id);
    
    //     if (is_null($song)) {
    //         return response()->json([
    //             'status' => false,
    //             'data' => null,
    //             'message' => 'Song data not found'
    //         ]);
    //     }

    //     $dataFields = $request->validate([
    //         "title" => "required",
    //         "track" => "nullable | mimes:mp3",
    //         "genre" => "required",
    //         "release_date" => "required",
    //         "album_id" => "nullable",
    //         "artist_id" => "required",
    //     ]);
        
        
    //     if ($request->hasFile('track')) {
    //         Storage::disk('public')->delete($song->track);
    //         $track = $request->file('track');
    //         $filePath = $track->store('tracks', 'public');
    //         $dataFields['track'] = $filePath;
    //     }
    
    //     $song->update($dataFields);
    
    //     return response()->json([
    //         'status' => true,
    //         'data' => $song,
    //         'message' => 'Song data updated successfully'
    //     ]);
    // }



    public function update(Request $request, $id)
        {
            
            $song = Song::find($id);
            
            if(is_null($song)){
                return response()->json([
                    'status' => false,
                    'data' => null,
                    'message' => 'Song not found'
                ]);
            }

            $request->validate([
                'title' => 'required',
                'genre' => 'required',
                'track' => 'nullable|mimes:mp3',
                'artist_id' => 'required',
                'album_id' => 'nullable',
                'release_date' => 'required'
            ]);

            // Selectively update song data
            $song->title = $request->input('title');
            $song->genre = $request->input('genre');
            $song->artist_id = $request->input('artist_id');
            $song->album_id = $request->input('album_id');
            $song->release_date = $request->input('release_date');

            // Handle track update if provided
            if ($request->hasFile('track')) {
                Storage::disk('public')->delete($song->track);
                $track = $request->file('track');
                $filePath = $track->store('tracks', 'public');
                $song->track = $filePath;
            }

            $song->save();

            return response()->json([
                'status' => true,
                'data' => $song,
                'message' => 'Song Updated Successfully'
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
