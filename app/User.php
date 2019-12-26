<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Accessors 
    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    //Laravel Query Scope 
    public function scopeLastName($query)
    {
        return $query->orderBy('id', 'desc')->first();
    }

    public function scopeLastActivatedUser()
    {
        return DB::table('users')
            ->select('users.*')
            ->join('activations', 'user_id', '=', 'activations.user_id')
            ->orderBy('activations.created_at', 'desc')
            ->first();
    }

   
}
