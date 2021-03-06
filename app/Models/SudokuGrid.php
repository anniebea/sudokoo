<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SudokuGrid extends Model
{
    use HasFactory;

    //To allow mass assignment of these fields
    protected $fillable = [
        'title',
        'user_id',
        'deleted_at'
    ];

    //FK relationship
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function contents() {
        return $this->hasMany('App\Models\SudokuGridContents');
    }

    public function rating() {
        return $this->hasMany('App\Models\Rating');
    }

    public function gridRule() {
        return $this->hasMany('App\Models\GridRule');
    }
}
