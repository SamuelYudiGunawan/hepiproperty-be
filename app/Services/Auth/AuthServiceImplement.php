<?php

namespace App\Services\Auth;

use App\Exceptions\ResponseException;
use App\Models\User;
use App\Repositories\Technoscape\TechnoscapeRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthServiceImplement implements AuthService
{
    private $technoscapeRepository;

    public function __construct(TechnoscapeRepository $technoscapeRepository)
    {
        $this->technoscapeRepository = $technoscapeRepository;
    }

    public function register(array $data)
    {
        try {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
                'phone' => $data['phone'],
            ]);

            $accessToken = $user->createToken('access_token')->plainTextToken;

            return ['user' => $user, 'access_token' => $accessToken];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw new ResponseException('Account not found', Response::HTTP_NOT_FOUND);
        }

        if (!$user->email === $data['email'] && !$user->password === $data['password']) {
            throw new ResponseException('Email or Password does not match', Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = $user->createToken('access_token')->plainTextToken;

        return ['user' => $user, 'access_token' => $accessToken];
    }
}
