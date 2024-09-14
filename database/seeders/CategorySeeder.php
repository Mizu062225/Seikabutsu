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
                'id' =>1,
                'name' => '音楽',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
        ]);
         
        DB::table('categories')->insert([
                'id' =>2,
                'name' => '服飾',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
        ]);
         
        DB::table('categories')->insert([
                'id' =>3,
                'name' => '美術',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
        ]);
         
        DB::table('categories')->insert([
                'id' =>4,
                'name' => '日常',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
        ]);
    }
}
