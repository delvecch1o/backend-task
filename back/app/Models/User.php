<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

 
    protected $fillable = [
        'type_user',
        'firstName',
        'lastName',
        'profession',
        'balance',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

    public function contractors()
    {
        return $this->hasMany(Contract::class , 'contractor_id');  
    }

    public function clients()
    {
        return $this->hasMany(Contract::class , 'client_id');  
    }

    public function jobsContractors()
    {
        return $this->hasMany(Job::class , 'contractor_id');  
    }

    public function jobsClients()
    {
        return $this->hasMany(Job::class , 'contract_id');  
    }

}
