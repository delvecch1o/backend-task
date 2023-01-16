<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{

    public function createProfile($type_user, $firstName, $lastName, $profession, $balance, $email, $password)
    {
        $user = User::create([
            'type_user' => $type_user,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'profession' => $profession,
            'balance' => $balance,
            'email' => $email,
            'password' => Hash::make($password),
                    
        ]);

        $token = $user->createToken($user->email . '_Token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
                
        ];
        
    }

    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();
        
        if(!$user || !Hash::check($password, $user->password))
        {
             throw new UnauthorizedHttpException('message', 'Credenciais Invalidas');
        } 
        else
        {
            $token = $user->createToken($user->email . '_Token')->plainTextToken;
            return [
                'user' => $user,
                'token' => $token
            ];
        }
        
    }

    public function logout()
    {
        auth()->user()->tokens()->delete(); 
    }
    
}