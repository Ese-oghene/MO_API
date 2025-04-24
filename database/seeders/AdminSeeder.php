<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::factory()->create([
            'email' => 'admin',
            'name' => 'Monika',
            'password' => Hash::make('1114444'),
            'phone_no' => '',
        ]);
        $user->setRole('admin');
        $user->assignRole('admin');

    }
}
