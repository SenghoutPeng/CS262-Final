<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'amount',
        'user_id',
        'event_id',
        'org_id',
        'payment_id',
        'commission_amount',
    ];



}
