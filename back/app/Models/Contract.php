<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $table = 'contracts';
    protected $fillable = [
       'terms',
       'status',
       'active',
       'client_id',
       'contractor_id',
        
    ];
    public function client()
    {
        return $this->belongsTo(User::class , 'client_id');
    }
    
    public function contractor()
    {
        return $this->belongsTo(User::class , 'contractor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    

}
