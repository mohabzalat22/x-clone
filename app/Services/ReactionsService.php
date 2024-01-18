<?php

namespace App\Services;
use App\Models\Comment;
use App\Models\Reaction;

Class ReactionsService
{
    public static function CountCommentsByTweetId($id){
        $comments_count = Comment::where('tweet_id', $id)->pluck('comment')->count(); 
        return $comments_count;
    }

    public static function CountHeartsByTweetId($id){
        $hearts_count = Reaction::where('tweet_id', $id)->where('heart', 1)->count(); 
        return $hearts_count;
    }

    public static function CountViewsByTweetId($id){
        $views_count = Reaction::where('tweet_id', $id)->where('viewed', 1)->count(); 
        return $views_count;
    }

    public static function CountRepostsByTweetId($id){
        $reposts_count = Reaction::where('tweet_id', $id)->where('repost', 1)->count(); 
        return $reposts_count;
    }
}