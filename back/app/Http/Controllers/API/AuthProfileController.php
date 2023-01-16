<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\AuthProfileRequest;
use App\Http\Requests\AuthLoginRequest;

class AuthProfileController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function profile(AuthProfileRequest $request)
    {
        $data = $this->authService->createProfile(
             ...array_values(
                $request->only([
                    'type_user',
                    'firstName',
                    'lastName',
                    'profession',
                    'balance',
                    'email',
                    'password',
                      
                ])
            )
        );
        return response()->json([
            'Dados do Usuario'=> $data,
            'message' => 'Usuario cadastrado com Sucesso!'
           
        ]);
    }

    public function login(AuthLoginRequest $request)
    {
        $data = $this->authService->login(
             ...array_values(
                $request->only([
                    'email',
                    'password'
                ])
            )
        );
        return response()->json([
            'details' => $data,
            'message' => 'Login Com Sucesso!'
        ]);

    }

    public function logout()
    {
        $this->authService->logout();
        return response()->json([
            'message' => 'Usuario saiu com Sucesso'
        ]);
    }

}
