<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;

class ReactionController extends Controller
{
    public function heart(Request $request){

        $request->validate([
            'tweet_id' => ['required']
        ]);

        $record = Reaction::where('user_id', auth()->user()->id)->where('tweet_id', $request->tweet_id);
        if($record->exists()){
            $record->update([
                'heart' => ! $record->first()->heart,
            ]);
            return back();
        }

        Reaction::create([
            'user_id' => auth()->user()->id,
            'tweet_id' => $request->tweet_id,
            'heart' => true
        ]);

        return back();
    }

    public function viewed(Request $request){

        $request->validate([
            'tweet_id' => ['required']
        ]);

        $record = Reaction::where('user_id', auth()->user()->id)->where('tweet_id', $request->tweet_id);
        if($record->exists()){
            $record->update([
                'viewed' => ! $record->first()->viewed,
            ]);
            return back();
        }
        
        Reaction::create([
            'user_id' => auth()->user()->id,
            'tweet_id' => $request->tweet_id,
            'viewed' => true
        ]);

        return back();
    }
}
