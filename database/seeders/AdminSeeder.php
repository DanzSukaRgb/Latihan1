<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name'              => 'Admin',
            'email'             => 'admin@absensi.test',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}