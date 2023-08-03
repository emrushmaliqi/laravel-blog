<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::insert("INSERT INTO permissions (name, guard_name) values ('view_posts', 'web'), ('edit_self_posts', 'web'), ('delete_self_posts', 'web'), ('create_posts', 'web'), ('edit_any_posts', 'web'), ('delete_any_posts', 'web')");
    }
}
