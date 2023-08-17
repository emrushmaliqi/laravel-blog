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
        DB::insert("INSERT INTO permissions (name, guard_name) values ('view_post', 'web'), ('edit_self_post', 'web'), ('delete_self_post', 'web'), ('create_post', 'web'), ('edit_any_post', 'web'), ('delete_any_post', 'web'), ('create_comment', 'web'), ('delete_self_comment', 'web'), ('delete_any_comment', 'web'), ('edit_self_comment', 'web'), ('edit_any_comment', 'web')");
    }
}
