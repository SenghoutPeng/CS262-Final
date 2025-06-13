<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event_proposal';
    protected $primaryKey = 'proposal_id';
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
