<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function register(AuthRequest $request): JsonResponse
    {
        $user = User::query()->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $token = $user->createToken("Sherif'sSecretKey")->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
            'success' => true
        ]);
    }

    public function logout(): JsonResponse
    {
        try {
            Auth::user()->tokens()->delete();
            return response()->json([
                'success' => true
            ]);
        } catch (Throwable $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage()
            ]);
        }
    }


    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::query()->where('email', $request->input('email'))->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not found'
                ], 404);
            }

            $hashedPw = Hash::check($request->input('password'),$user->password);

            if (!$hashedPw) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password doesnt match'
                ]);
            }

            $token = $user->createToken("Sherif'sSecretKey")->plainTextToken;

            return response()->json([
                'data' => $user,
                'success' => true,
                'token' => $token
            ]);
        } catch (Throwable $error) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $error->getMessage()
            ]);
        }
    }
}
