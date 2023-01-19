<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function query(Request $request)
    {
        $userType = Auth::user()->type_user;
        if($userType === 'contractor')
        {
            $user = Auth::user();
            $listJobsPay = $user
                    ->jobsContractors()
                    ->where('paid', '=', '1')
                    ->get();
            
    
            $allValueJobsPay =  $listJobsPay->pluck('price')->all(); 
            $sumAllValueJobs = array_sum($allValueJobsPay); 
            
        }
        else 
        {
            $user = Auth::user();
            $listJobsPay = $user
                    ->jobsClients()
                    ->where('paid', '=', '1')
                    ->get();
            
            $allValueJobsPay =  $listJobsPay->pluck('price')->all(); 
            $sumAllValueJobs = array_sum($allValueJobsPay); 

        }
    
        

        $profession = DB::table('users')
                            ->pluck('balance', 'profession')
                            ->all();

        $valueProfessionPlusPay = max($profession);
        $professionName = array_search($valueProfessionPlusPay, $profession);

        
        return response()->json([
            'profile' => $userType,
           // 'all profession' => $profession,
            'best profession' => $professionName,
            'value' => $valueProfessionPlusPay,
            'Valor de todos Trabalhos Pagos' => $sumAllValueJobs
        ]);
    }
}
