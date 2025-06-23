<?php

namespace App\Models;

use App\Models\Rating;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable, HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //     ->logOnly(['username', 'email'])
    //     ->useLogName('user')
    //     ->logOnlyDirty();
    //     // Chain fluent methods for configuration options
    // }
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function ratings()
{
    return $this->hasMany(Rating::class);
}

}
