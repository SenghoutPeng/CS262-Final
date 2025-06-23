<?php

namespace App\Models;

use App\Models\Rating;
use App\Models\EventCategory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'event_id';
    protected $fillable = [
        'title', 'description', 'location', 'ticket_price', 'total_ticket',
        'event_category_id', 'proposed_date', 'event_time', 'org_id', 'banner'
    ];

    public function categories()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
