<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = 'payment';
    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'amount',
    ];
}
