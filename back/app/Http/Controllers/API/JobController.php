<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JobService;
use App\Http\Requests\JobRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Contract;
use App\Models\Job;

class JobController extends Controller
{
    private JobService $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function store(JobRequest $request)
    {
        $contractor = Auth::user();
        $contract = Contract::find($request->get('contract_id'));
        $description = $request->get('description');
        $price = $request->get('price');
        $paid = $request->get('paid');
        $payment_date = $request->get('payment_date');
        
        $data = $this->jobService->createService(
            $contractor, $contract, $description , $price, $paid, $payment_date
        );
            return response()->json([
                'Dados do Trabalho' => $data,
                'message' => 'Trabalho criado com Sucesso!'
            ]);
       
    }

    public function show()
    {
        $showList = $this->jobService->showService();
        
        return response()->json([
            'Lista de Trabalhos' => $showList,
        ]);
    }

    public function payment(Request $request, Job $job)
    {
        $payment = $this->jobService->makePayment($job);
        
        
        return response()->json([
            'message' => 'Pagamento realizado com sucesso!',
            'Pagamento do Trabalaho' => $payment,
            
        ]);
    }


}
