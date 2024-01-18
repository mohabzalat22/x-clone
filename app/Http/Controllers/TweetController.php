<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index()
    // {
    // }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // VALIDATION 
        $request->validate([
            'data' => ['string','nullable'],
            'file'=> ['mimes:png,jpg,jpeg,mp4','nullable']
        ]);

        if($request->file){
            // SAVING DATA TO TWEETS TABLE
            $fileName  = time() . '.' . $request->file->extension();
    
            // AVAILABLE EXTENSIONS
            $image_available_extinsions = ['png','jpg','jpeg'];
            $video_available_extinsions = ['mp4'];
    
            if(in_array($request->file->extension(), $image_available_extinsions))
            {
                $request->file->move(public_path('images'), $fileName);
            } 
            elseif(in_array($request->file->extension(), $video_available_extinsions)){
                $request->file->move(public_path('videos'), $fileName);
            }
    
            // CREATE NEW TWEET
            Tweet::create([
                'user_id' => auth()->user()->id,
                'data' => $request->data,
                'source' => $fileName
            ]);
        }
        else {
            Tweet::create([
                'user_id' => auth()->user()->id,
                'data' => $request->data,
            ]);
        }
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tweet = Tweet::find($id);
        return view('layouts.tweet',['tweet'=>$tweet]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
