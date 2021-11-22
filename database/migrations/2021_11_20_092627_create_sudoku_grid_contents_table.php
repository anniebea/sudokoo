<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSudokuGridContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sudoku_grid_contents', function (Blueprint $table) {
            $table->id();
            $table->string('cell_num',16);
            $table->string('cell_content',8);
            $table->foreignId('sudoku_grid_id')->constrained();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sudoku_grid_contents');
    }
}
