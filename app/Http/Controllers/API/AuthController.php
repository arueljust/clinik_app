<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // check user if exist
        $user = User::where('email',$req->email)->first();

        // check if pass correct
        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'email atau password salah nih'
            ]);
        }

        //if success generate token
        $token = $user->createToken('auth-token')->plainTextToken;
        $user->token_type = 'Bearer';

        return response()->json([
            'status' => 200,
            'message' => 'Auth success dong',
            'data' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $req)
    {
        $req->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'logout success dong'
        ]);
    }
}
