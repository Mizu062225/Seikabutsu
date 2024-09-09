<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
                'name' => 'Music',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
         
        DB::table('categories')->insert([
                'name' => 'Fashion',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
         
        DB::table('categories')->insert([
                'name' => 'Art',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
    }
}
