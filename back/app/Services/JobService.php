<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


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

    public function makePayment(Job $job)
    {
        $userType = Auth::user()->type_user;
        if($userType === 'contractor')
        {
            throw ValidationException::withMessages(
                ['message' => 
                'Os trabalhos são pagos somente por Clientes',
                'Type User => ' .$userType
            ]);
        }

        $guardPriceJob = $job->price; 
        $payerClient = Auth::user(); 
        $payeeContractor = $job->contractor()->first(); 

        if($payerClient->balance < $guardPriceJob)
        {
            throw ValidationException::withMessages(
                ['message' => 
                'Você não tem saldo suficiente para fazer o pagamento',
                'Saldo => ' .$payerClient->balance
            ]);
                
        }
    
        $transactionResult = DB::transaction(function () use ($payerClient, $payeeContractor, $guardPriceJob, $job){

            $payerClient->balance -=  $guardPriceJob;
            $payerClient->save();
            
            $payeeContractor->balance += $guardPriceJob;
            $payeeContractor->save();

            $job->update([
                'paid' => true,
                'active' => false,
                'payment_date' => Carbon::now()
            ]);
            return $job;
           
        });
        return $transactionResult;

    }
        
}