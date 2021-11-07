<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blocking extends Model
{
    use HasFactory;

    //To allow mass assignment of these fields
    protected $fillable = [
        'date_from',
        'date_to',
        'user_id',
        'created_at'
    ];

    //FK relationship
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
