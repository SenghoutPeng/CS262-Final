<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class Organization extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'organization';
    protected $primaryKey = 'org_id';
    protected $guards = 'organization';

    protected $fillable = [
        'org_name',
            'email' ,
            'password' ,
            'org_type',
            'contact_name',
            'contact_phone',
            'contact_email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
