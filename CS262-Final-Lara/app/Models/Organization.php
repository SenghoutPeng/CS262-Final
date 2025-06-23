<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Organization extends Authenticatable
{
    use HasApiTokens, Notifiable, LogsActivity;
    protected $table = 'organization';
    protected $primaryKey = 'org_id';
    protected $guard = 'organization';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['org_name', 'org_id']) // fields to track
        ->useLogName('organization')            // label for the log
        ->logOnlyDirty();
    }
    protected $fillable = [
        'org_name',
            'email' ,
            'password' ,
            'org_type',
            'contact_name',
            'contact_phone',
            'contact_email',
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
