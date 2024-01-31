<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

use App\Models\User;

class ProfileController extends Controller
{
    public function show($profile)
    {
        $user =  User::find($profile);
        $tweets = Tweet::where('user_id',$profile)->get();
        return view('profile',[
            'auth_user' => auth()->user(),
            'user' =>$user,
            'profile' => $profile,
            'tweets' => $tweets,
            'notifications' => User::find(auth()->user()->id)->unreadNotifications,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['string','max:255','nullable'],
            'bio' => ['string','max:255','nullable'],
            'website' => ['string','max:255','nullable'],
            'location' => ['string','max:255','nullable'],
            'background_picture' => ['mimes:jpeg,png,jpg','max:2048','nullable'],
            'profile_picture' => ['mimes:jpeg,png,jpg','max:2048','nullable'],
        ]);
        // NAMING
        // SAVING
        if($request->file('background_picture') && !$request->file('profile_picture')){
            $background_picture = time() . '.' . $request->file('background_picture')->extension();
            $request->file('background_picture')->storeAs('profileAssets/images', $background_picture , 'public');
            User::where('id', $request->profile )->update(['background_picture' => $background_picture]);
        }

        if($request->file('profile_picture') && !$request->file('background_picture')){
            $profile_picture = time() . '.' . $request->file('profile_picture')->extension();
            $request->file('profile_picture')->storeAs('profileAssets/images', $profile_picture, 'public');  
            User::where('id', $request->profile )->update(['profile_picture' => $profile_picture]);
        }

        if($request->file('profile_picture') && $request->file('background_picture')){
            $background_picture = time() . '.' . $request->file('background_picture')->extension();
            $profile_picture = time() + 1 . '.' . $request->file('profile_picture')->extension(); // epoch time :)

            $request->file('background_picture')->storeAs('profileAssets/images', $background_picture , 'public');
            $request->file('profile_picture')->storeAs('profileAssets/images', $profile_picture, 'public');  

            User::where('id', $request->profile )->update(
                [
                    'background_picture' => $background_picture ,
                    'profile_picture' => $profile_picture 
                ]);
        } 

        if($request->bio){
            User::where('id', $request->profile )->update(['bio' => $request->bio]);
        }
        return back();
    }
}
