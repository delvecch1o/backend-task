<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'jobs';
    protected $fillable = [
       'description',
       'price',
       'paid',
       'payment_date',
       'active',
       'contractor_id',
       'contract_id',
        
    ];
  
    public function contractor()
    {
        return $this->belongsTo(User::class , 'contractor_id');
    }

    public function contract()
    {
        return $this->belongsTo(User::class , 'contract_id');
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }


}
