<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::insert("INSERT INTO categories (name, slug) values ('Adventure', 'adventure'), ('Technology', 'tech'), ('Cuisine', 'cuisine'), ('Style', 'style'), ('Wellness', 'wellness'), ('Finance', 'finance')");
    }
}
