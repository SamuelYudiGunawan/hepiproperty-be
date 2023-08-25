<?php

namespace App\Services\Auth;

interface AuthService
{
    public function register(array $data);
    public function login(array $data);
}
