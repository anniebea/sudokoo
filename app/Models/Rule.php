<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    //To allow mass assignment of these fields
    protected $fillable = [
        'name',
        'description'
    ];

    //FK relationship
    public function gridRule() {
        return $this->hasMany('App\Models\GridRule');
    }
}
