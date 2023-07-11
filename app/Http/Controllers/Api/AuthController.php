<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrarRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registrar(RegistrarRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        $user->find($user->id);

        $user['access_token'] = $user->createToken('auth-token')->plainTextToken;

        return response()->json($user);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => [
                        'Invalid credentials'
                    ],
                ]
            ], 422);
        }

        $user = User::where('email', $data['email'])->first();
        
        $user['access_token'] = $user->createToken('auth-token')->plainTextToken;

        return response()->json($user);
    }

    public function logout(){
        
        $user = User::find(auth()->user()->id);

        $user->tokens()->delete();

        return true;
    }
}
