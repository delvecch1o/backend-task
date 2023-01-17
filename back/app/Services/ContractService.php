<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ContractService
{

    public function createService(User $client, User $contractor, $terms, $status)
    {
        $userType = Auth::user()->type_user;
        if($userType === 'contractor')
        {
            throw ValidationException::withMessages(
                ['message' => 
                'A Elaboração de contratos é atividade somente dos Clientes',
                'Type User => ' .$userType
            ]);
        }
        
        if($status === 'in_progress')
        {
            $activeOrInactive = true;
        }
        else 
        {
            $activeOrInactive = false;
        }

        
        $guardClientAuth = Auth::user()->id;
        $guardContractor = $contractor->id;
     
        $contractData = Contract::create([
            'terms' => $terms,
            'status' => $status,
            'active' =>  $activeOrInactive,
            'client_id' =>  $guardClientAuth,
            'contractor_id' =>  $guardContractor,
            
        ]);
        return $contractData;
        
    }

    public function showDetailsService(Contract $contract)
    {
        $user = Auth::user();
        $showDetailsContract =  $user->clients()->find($contract->id);
        return $showDetailsContract;
    }

    public function showService()
    {
        $userType = Auth::user()->type_user;

        if($userType === 'contractor')
        {
            $user = Auth::user();
            $listOfContractsContractor  = $user
                            ->contractors()
                            ->where('status', '<>', 'terminated')
                            ->get();
            return [
                'Profile' => $userType,
                'list' => $listOfContractsContractor,
               
            ];
        }
        
        else 
        {
            $user = Auth::user();
            $listOfContractsClients  = $user
                        ->clients()
                        ->where('status', '<>', 'terminated')
                        ->get();
            return [
                'Profile' => $userType,
                'list' => $listOfContractsClients,
                
            ];
            
        }
        

      
    }

}