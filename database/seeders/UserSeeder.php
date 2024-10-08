<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
                'name' => 'test',
                'email' => 'test@test',
                'email_verified_at' => now(),
                'password' => Hash::make('testtest'),
                'remember_token' => Str::random(10),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
        
        DB::table('users')->insert([
                'name' => 'test2',
                'email' => 'test2@test',
                'email_verified_at' => now(),
                'password' => Hash::make('testtest2'),
                'remember_token' => Str::random(10),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);

        User::factory()->count(10)->create();
    }
}
