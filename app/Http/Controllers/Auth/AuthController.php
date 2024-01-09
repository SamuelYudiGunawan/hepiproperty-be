<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AgentIndexing;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ], 400);
        }

        $user = User::where('email', $request['email'])->first();
        if ($user) {
            $passwordUser = Hash::check($request->password, $user->password);
        }
        if (!$user || !$passwordUser) {
            return response()
                ->json([
                    'message' => 'Email or Password not correct',
                    'status'  => 'error'
                ], 400);
        }
        $role = $user->getRoleNames()->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            "message" => 'Login Success',
            "token" => $token,
            "role" => $role,
        ],200);
    }

    public function Register (Request $request): \Illuminate\Http\JsonResponse
    {
        $user = new User;
        return $user->register($request);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => 'Logout Success',
        ],200);
    }
}
