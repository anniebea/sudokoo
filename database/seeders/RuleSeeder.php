<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rules')->truncate();

        DB::table('rules')->insert(array(
            array(
                'name' => 'Classic Sudoku',
                'description' => 'Every row, column and box must contain the digits 1-9 without repeats.'
            ),

            array(
                'name' => 'Windoku',
                'description' => 'Every marked 3x3 region must contain the digits 1-9 without repeats.'
            ),

            array(
                'name' => 'Chess Knight',
                'description' => 'Cells that are a Chess Knight\'s distance away from each other must not contain the same digits (e.g. the cell r2c2 must not contain the same digit as cells r1c4, r3c4, r4c1, and r4c3).'
            ),

        ));

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }
}
