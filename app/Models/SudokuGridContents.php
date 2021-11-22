<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SudokuGridContents extends Model
{
    use HasFactory;

    //To allow mass assignment of these fields
    protected $fillable = [
        'cell_num',
        'cell_content',
        'sudoku_grid_id',
        'deleted_at'
    ];

    //FK relationship
    public function sudokuGrid() {
        return $this->belongsTo('App\Models\SudokuGrid');
    }
}
