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
        $guardStatusContract = $contract->active;
     
        $jobData = Job::create([
            'description' => $description,
            'price' => $price,
            'paid' =>  $paid,
            'payment_date' =>  $payment_date,
            'active' => $guardStatusContract,
            'contractor_id' =>  $guardContractorAuth,
            'contract_id' => $guardContract,
            
        ]);
        
        return $jobData;

    }

    public function showService()
    {
        $userType = Auth::user()->type_user;

        if($userType === 'contractor')
        {
            $user = Auth::user();
            $listJobsOfContractors  = $user
                        ->jobsContractors()
                        ->where('paid', '=', '0')
                        ->where('active', '=', '1')
                        ->get();
            return [
                'Profile' => $userType,
                'list' => $listJobsOfContractors,
               
            ];
        }
        else
        {
            $user = Auth::user();
            $listJobsOfClients  = $user
                        ->jobsClients()
                        ->where('paid', '=', '0')
                        ->where('active', '=', '1')
                        ->get();
  
            return [
                'Profile' => $userType,
                'list' => $listJobsOfClients,
            
            ];

        }

    }

}