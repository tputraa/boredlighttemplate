<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuAccessSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        foreach ([1, 2, 3] as $roleId) {
            foreach ([1, 2, 3, 4, 5, 6] as $menucode) {
                $data[] = [
                    'user_group_id' => $roleId,
                    'menucode' => $menucode,
                    'fview' => 1,
                    'fadd' => $roleId === 3 ? 0 : 1,
                    'fedit' => $roleId === 3 ? 0 : 1,
                    'fdelete' => $roleId === 1 ? 1 : 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('menuaccess')->insert($data);
    }
}
