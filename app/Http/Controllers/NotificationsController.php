<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificationsController extends Controller
{
    public function show()
    {
        $user = User::find(auth()->user()->id);
        $notifications = $user->unreadNotifications;
        $notifications->markasRead();
        return view('notifications', [
            'auth_user' => auth()->user(),
            'notifications' => $notifications
        ]);
    }
}
