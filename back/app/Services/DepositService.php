<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DepositService
{
    public function depositService(User $user, $depositValue)
    {
        $userType = Auth::user()->type_user;
        if($userType === 'contractor')
        {
            throw ValidationException::withMessages(
                ['message' => 
                'Os Depositos são feitos apenas por clientes',
                'Type User => ' .$userType
            ]);
        }
     
        $user = Auth::user();
        $listJobsOfClients  = $user
                            ->jobsClients() 
                            ->where('paid', '=', '0')
                            ->where('active', '=', '1')
                            ->get();
    
        $jobsToPay =  $listJobsOfClients->pluck('price')->all(); 
        $sumAllJobsToPay = array_sum($jobsToPay); 
        $rateForDeposit =  $sumAllJobsToPay * 0.25;
        $valuePermissionToDeposit =  $sumAllJobsToPay + $rateForDeposit;
        
        if($depositValue > $valuePermissionToDeposit)
        {
            throw ValidationException::withMessages(
                ['message' => 
                'Não pode depositar um valor maior que 25% do total de trabalhos a pagar',
                'Valor Maximo Para Deposito => ' .$valuePermissionToDeposit
            ]);
        }

        $firstName = $user->firstName;
        $balanceUserAuth = $user->balance;
        $newBalance = $balanceUserAuth + $depositValue;  
        
        $user->update([
            'firstName' =>  $firstName,
            'balance' =>  $newBalance
        ]);
     
        return [
            'Deposito' => $depositValue,
            'Saldo Atual' => $user->balance,
            'Dados do Usuario' => $user,
        ];
    }

}