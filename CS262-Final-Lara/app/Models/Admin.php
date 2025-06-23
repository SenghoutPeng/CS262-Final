<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Admin extends Authenticatable
{
    use HasApiTokens,Notifiable, LogsActivity, HasFactory;
    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    protected $guard = 'admin';



    public function getActivitylogOptions(): LogOptions
    {
 return LogOptions::defaults()
            ->logOnly(['username']) // fields to track
            ->useLogName('admin')            // label for the log
            ->logOnlyDirty();
    }
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
}
