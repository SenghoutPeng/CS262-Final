<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Organization extends Authenticatable
{
    use HasApiTokens, Notifiable;

     protected $table = 'organization';
     protected $primaryKey = 'org_id';

    protected $fillable = [
    'org_name',
    'email',
    'password',
    'contact_name',
    'contact_phone',
    'contact_email',
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'password' => 'hashed', 
    ];
}
