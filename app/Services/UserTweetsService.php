<?php

namespace App\Services;
use App\Models\User;
use App\Models\Tweet;


class UserTweetsService {
    public static function getFollowingTweets($userId){
        $user = User::find($userId);
        if($user != null){
            $followings = $user->friends->pluck('following_id'); // followings ids
            return Tweet::whereIn('user_id', $followings)?->get(); // tweets of followings
        }
    }
}