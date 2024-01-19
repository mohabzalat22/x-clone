<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ApiController extends Controller
{
    public function show(Request $request)
    {
        if($request->user == null) {
            return response()->json();
        }
        $users = User::where('name','LIKE', $request->user . "%")->get();
        return  response()->json($users);
    }
}
