<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $table = 'ticket';
    protected $primaryKey = 'ticket_id';
    protected $fillable = [
        'quantity',
        
    ];
}
