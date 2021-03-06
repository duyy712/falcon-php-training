<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
            'is_admin' => 'boolean',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        // if (auth()->user()->is_admin) {
        //     $accessToken = auth()->user()->createToken('authToken', ['admin'])->accessToken;
        // } else {
        //     $accessToken = auth()->user()->createToken('authToken', ['user'])->accessToken;
        // }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;


        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function logout()
    {
        if (auth('api')->check()) {
            auth('api')->user()->oauthAccessToken()->delete();

            return response(['message' => 'Log out successfully']);
        } else {
            return response(['message' => 'Error occurred']);
        }
    }
}
