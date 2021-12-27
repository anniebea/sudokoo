<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    // to allow mass assignment of these fields
    protected $fillable = [
        'is_positive',
        'sudoku_grid_id',
        'user_id'
    ];

    //FK relationship
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function sudokuGrid() {
        return $this->belongsTo('App\Models\SudokuGrid');
    }
}
