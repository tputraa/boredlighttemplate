<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user_group')->insert([
            ['roleid' => 1, 'rolename' => 'Administrator', 'isactive' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['roleid' => 2, 'rolename' => 'Manager', 'isactive' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['roleid' => 3, 'rolename' => 'Operator', 'isactive' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
