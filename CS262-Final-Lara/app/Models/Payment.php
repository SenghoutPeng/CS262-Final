<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'org_name',
            'email' ,
            'password' ,
            'org_type',
            'contact_name',
            'contact_phone',
            'contact_email',
    ];
}
