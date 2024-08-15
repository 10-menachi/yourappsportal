<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'YourApps QR Code',
            'email' => 'qrcode@yourapps.co.ke',
            'password' => bcrypt('123456789'),
        ]);
    }
}
