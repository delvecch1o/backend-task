<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ContractService;
use App\Http\Requests\ContractRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Contract;

class ContractController extends Controller
{
    private ContractService $contractService;

    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;
    }

    public function store(ContractRequest $request)
    {
        $client = Auth::user();
        $contractor = User::find($request->get('contractor_id'));
        $terms = $request->get('terms');
        $status = $request->get('status');
        
        $data = $this->contractService->createService(
            $client, $contractor, $terms , $status
        );
            return response()->json([
                'Dados do Contrato' => $data,
                'message' => 'Contrato criado com Sucesso!'
            ]);
       
    }

    public function showDetails(Contract $contract)
    {
        $showDetailsContract = $this->contractService->showDetailsService($contract);
        return response()->json([
            'Detalhes Do Contrato' => $showDetailsContract
        ]);
    }

    public function show()
    {
        $showListOfContracts = $this->contractService->showService();
        
        return response()->json([
            'Lista de Contratos' => $showListOfContracts,
        ]);
    }

}
