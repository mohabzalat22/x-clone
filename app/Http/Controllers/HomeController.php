<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tweet;

class HomeController extends Controller
{

    // index => view
    public function index()
    {
        return view('home',[
            'auth_user' => Auth::user(),
            'tweets' =>Tweet::all()->sortByDesc('created_at'),
        ]);
    }   
}
