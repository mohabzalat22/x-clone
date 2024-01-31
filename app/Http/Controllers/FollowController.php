<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use App\Models\User;
use App\Services\FriendService;
use App\Notifications\FollowRequest;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $request->validate([
            'profile' => ['required', 'string']
        ]);
        if (FriendService::isFriend(auth()->user()->id, $request->profile)){ return back();} //check is he is friend
        else{
            //create friend
            Friend::create([
                'follower_id' => auth()->user()->id,
                'following_id' => $request->profile
            ]);
            //sending notification via mail to the following
            $user = User::find($request->profile);
            $user->notify(new FollowRequest(auth()->user()));
            // send notification auth has followed someone
            return back();
        }
    }
}
