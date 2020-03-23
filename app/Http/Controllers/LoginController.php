<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        /*$login = $request->validate([
            'email' => 'required|string',
            'passowrd' => 'required|string'
        ]);

        return "12";*/

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response(['message' => 'Invalid login credentials!']);
        }


        $accessToken = Auth::user()->createToken('Token authToken')->accessToken;;

        return response([
            'user' => Auth::user(),
            'access_token' => $accessToken
        ]);
    }
}
