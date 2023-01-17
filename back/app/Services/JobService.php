<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class JobService
{
    public function createService(User $contractor, Contract $contract, $description, $price, $paid, $payment_date )
    {
        $userType = Auth::user()->type_user;
        if($userType === 'client')
        {
            throw ValidationException::withMessages(
                ['message' => 
                'Os trabalhos não pode ser criados por clientes',
                'Type User => ' .$userType
            ]);
        }

        $guardContractorAuth = Auth::user()->id;
        $guardContract = $contract->id;
     
        $jobData = Job::create([
            'description' => $description,
            'price' => $price,
            'paid' =>  $paid,
            'payment_date' =>  $payment_date,
            'contractor_id' =>  $guardContractorAuth,
            'contract_id' => $guardContract,
            
        ]);
        return $jobData;


    }
}