<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        $email = $request->get("email");
        $password = $request->get("password");

        if(Auth::attempt(compact('email', 'password')))
        {
            $user = auth()->user();
            $access_token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => "User Authenticated Successfully",
                'token' => $access_token
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => "Invalid Username or Password"
            ]);
        }
    }


    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->pfp = $request->get('pfp');
        $user->password = bcrypt($request->get('password'));
        $user->save();

        $access_token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => "User Registered Successfully",
                'token' => $access_token
            ]);
    }


}
