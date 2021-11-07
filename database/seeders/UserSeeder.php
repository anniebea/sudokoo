<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the user seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();

        DB::table('users')->insert(array(
            array(
                'name' => 'Lietotajs',
                'email' => 'lietotajs@sudokoo.lv',
                'date_of_birth' => Carbon::create(2000,1,1),
                'password' => bcrypt('Sudokoo123!'),
                'role_id' => DB::table('Roles')->where('name','Pamatlietotajs')->value('id')
            ),

            array(
                'name' => 'Administrators',
                'email' => 'administrators@sudokoo.lv',
                'date_of_birth' => Carbon::create(2000,1,1),
                'password' => bcrypt('Sudokoo123!'),
                'role_id' => DB::table('Roles')->where('name','Administrators')->value('id')
            ),

            array(
                'name' => 'Verificets',
                'email' => 'verificets@sudokoo.lv',
                'date_of_birth' => Carbon::create(2000,1,1),
                'password' => bcrypt('Sudokoo123!'),
                'role_id' => DB::table('Roles')->where('name','Pamatlietotajs')->value('id')
            ),

            array(
                'name' => 'Blokets',
                'email' => 'blokets@sudokoo.lv',
                'date_of_birth' => Carbon::create(2000,1,1),
                'password' => bcrypt('Sudokoo123!'),
                'role_id' => DB::table('Roles')->where('name','Pamatlietotajs')->value('id')
            ),
        ));

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
