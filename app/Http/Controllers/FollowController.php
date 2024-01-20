<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $request->validate([
            'profile' => ['required', 'string']
        ]);
        if (\App\Services\FriendService::isFriend(auth()->user()->id, $request->profile)){ return back();}
        else{
            Friend::create([
                'follower_id' => auth()->user()->id,
                'following_id' => $request->profile
            ]);
            return back();
        }
    }
}
