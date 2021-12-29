<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GridRule extends Model
{
    use HasFactory;

    //To allow mass assignment of these fields
    protected $fillable = [
        'sudoku_grid_id',
        'rule_id'
    ];

    //FK relationship
    public function sudokuGrid() {
        return $this->belongsTo('App\Models\SudokuGrid');
    }

    public function rule() {
        return $this->belongsTo('App\Models\Rule');
    }
}
