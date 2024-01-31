<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserTweetsService;
use App\Models\User;

class HomeController extends Controller
{
    // index => view
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $notifications = $user->unreadNotifications;
        return view('home',[
            'auth_user' => auth()->user(),
            // 'tweets' =>Tweet::all()->sortByDesc('created_at'),
            'tweets' => UserTweetsService::getFollowingTweets(auth()->user()->id),
            'notifications' => $notifications
            
        ]);
    }   
}
