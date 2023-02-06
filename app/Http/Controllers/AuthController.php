<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request): JsonResponse
    {

        $request->validate([
            'email'    => 'required|email|string',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized'
            ]);
        }
        $user = Auth::user();

        return response()->json([
            'status'        => 'success',
            'user'          => $user,
            'Authorization' => [
                'token' => $token,
                'type'  => 'bearer'
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::query()->create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->passowrd)
        ]);
        $token = Auth::login($user);


        return response()->json([
            'status'        => 'success',
            'message'       => 'User Created successfully!',
            'user'          => $user,
            'authorization' => [
                'token' => $token,
                'type ' => 'bearer'
            ]
        ]);

    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status'  => 'sucess',
            'message' => 'successfully logged out']);
    }

    public function refresh()
    {
        return response()->json([
            'status'        => 'success',
            'user'          => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type'  => 'bearer'
            ]
        ]);
    }

}

