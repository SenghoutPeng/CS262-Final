<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    //
    protected $table = 'event_category';
    protected $primaryKey = 'event_category_id';
    protected $fillable = [
        'event_category_name',
    ];
}
