<?php

namespace App\Models;


use App\Models\User;
use App\Models\Event;
use App\Models\RatingCategory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
    protected $table = 'rating';
    protected $primaryKey = 'raing_id';
    protected $fillable = [
        'rating',
        'rating_category_id'
    ];

    public function users() { return $this->belongsTo(User::class); }
    public function events() { return $this->belongsTo(Event::class); }
    public function categories() { return $this->belongsTo(RatingCategory::class, 'rating_category_id'); }

}
