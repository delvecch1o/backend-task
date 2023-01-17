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
       'contractor_id',
       'contract_id',
        
    ];

    public function job()
    {
        return $this->belongsTo(Contract::class);
    }

}
