<?php

namespace App\Services;
use App\Models\Friend;

class FriendService {
    public static function isFriend($auth_user_id, $profile_id){
        return Friend::where('follower_id', $auth_user_id)->where('following_id', $profile_id)->exists();
    }

    public static function friendsCount($user_id){
        $follower = Friend::where('follower_id', $user_id)->count();
        $following = Friend::where('following_id', $user_id)->count();
        return [
            $follower,
            $following
        ];
    }
}