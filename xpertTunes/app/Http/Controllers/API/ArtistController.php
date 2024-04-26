<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ArtistRequest;
use App\Models\Artist;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artist::all();
        return response()->json([
            'status' => true,
            'data' => $artists,
            'message' => 'lists of artists'

        ]);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArtistRequest $request)
    {
        $artist = Artist::create($request->all());
        return response()->json([
            'status' => true,
            'data' => $artist,
            'massage' => 'Artist Created Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $artist = Artist::find  ($id);
        if($artist){
            return response()->json([
                'status' => true,
                'data' => $artist,
                'massage' => 'Artist information'
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'data' => null,
                'massage' => 'Artist not Found'
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
    public function update(ArtistRequest $request, string $id)
    {
        $artist = Artist::find($id);
        $artist->update($request->all());
        return response()->json([
            'status' => true,
            'data' => $artist,
            'massage' => 'Artist Updated Succsessfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = Artist::destroy($id);
        if($result)
        {
            return response()->json([
                'status' => true,
                'data' => null,
                'message' => 'Artist Deleted Successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Artist not Found'
            ]);
        }
    }


    public function albums($id, Request $request)
    {
        $artist= Artist::find($id);
        if(!is_null($artist))
        {
            $albums=$artist->albums;
            return response()->json([
                'status' => true,
                'data' => $albums,
                'message' => 'Albums of a specific artist'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Artist not Found'
            ]);
        }
    }

    public function songs($id, Request $request)
    {
        $artist = Artist::find($id);
        if(!is_null($artist))
        {
            $songs = $artist->songs;
            return response()->json([
                'status'=>true,
                'data'=>$songs,
                'message'=>'Songs for Specific Artist'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>'Artist not Found'
            ]);
        }
    }

    /* public function albums($id, Request $request)
    {
        $artist= Artist::with('albums')->find($id);
        if(!is_null($artist))
        {
            return response()->json([
                'status' => true,
                'data' => $artist,
                'message' => 'Albums of a specific artist'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Artist not Found'
            ]);
        }
    } */
}
