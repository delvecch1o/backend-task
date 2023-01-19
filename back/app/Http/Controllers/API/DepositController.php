<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DepositService;
use App\Models\User;
use App\Http\Requests\DepositRequest;

class DepositController extends Controller
{

    private DepositService $depositService;

    public function __construct(DepositService $depositService)
    {
        $this->depositService = $depositService;
    }
  

    public function deposit(DepositRequest $request, User $user)
    {
        $balance = $this->depositService->depositService(
            $user,
            ...array_values(
                $request->only([
                    'balance'
                ])
            )
        );
        return response()->json([
            'status' => $balance,
            
        ]);
        
    }

}
