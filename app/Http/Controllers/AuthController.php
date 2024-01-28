<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //
    public function index()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['email','required'],
            'password' => ['string','required','max:255']
        ]);
        
        if(auth()->attempt($request->only(['email','password']))){
            return redirect()->route('home');
        }
        return redirect('/')->withErrors('Error during authentication');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['string','required','max:255'],
            'email' => ['email','required','unique:users,email'],
            'password' => ['string','required','max:255']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        Mail::to($user->email)->send(new Welcome($user));
        auth()->login($user);
        return redirect()->route('home');
    }
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
