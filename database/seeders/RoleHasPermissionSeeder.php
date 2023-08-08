<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::insert("INSERT INTO role_has_permissions (role_id, permission_id) VALUES (1 , 1),(1 , 2),(1 , 3),(1 , 4),(1 , 5),(1 , 6),(1, 7),(1, 8),(1,9),(2 , 1), (2 , 2),(2 , 3),(2 , 4),(2,7),(2,8)");
    }
}
