<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the role seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();

        DB::table('roles')->insert(array(
            array(
                'name' => 'BaseUser',
                'description' => 'Base user of the system, no special permissions added.'
            ),

            array(
                'name' => 'Admin',
                'description' => 'System administrator, has access to user accounts, the ability to change user roles, block users from the system, moderate comments.'
            ),

        ));

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }
}
