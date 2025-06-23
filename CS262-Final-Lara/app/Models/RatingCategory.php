<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;

class RatingCategory extends Model
{
    //
    protected $table = 'rating_category';
    protected $primaryKey = 'rating_category_id';
    protected $fillable = [
        'rating_category_name',

    ];

    public function rating()
{
        return $this->hasMany(Rating::class, 'rating_category_id');
}
}
