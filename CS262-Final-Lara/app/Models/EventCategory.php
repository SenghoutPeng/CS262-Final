<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    //
    protected $table = 'event_category';
    protected $primaryKey = 'event_category_id';
    protected $fillable = [
        'event_category_name',
    ];

    
    public function events()
    {
        return $this->hasMany(Event::class, 'event_category_id');
    }
}
