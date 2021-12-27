<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'date_of_birth',
        'password',
        'role_id',
        'is_blocked'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    //FK relationship
    public function role() {
        return $this->belongsTo('App\Models\Role');
    }

    //FK relationship
    public function blocking() {
        return $this->hasMany('App\Models\Blocking');
    }

    //FK relationship
    public function sudokuGrid() {
        return $this->hasMany('App\Models\SudokuGrid');
    }

    //FK relationship
    public function rating() {
        return $this->hasMany('App\Models\Rating');
    }
}
