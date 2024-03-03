<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $google2fa = app('pragmarx.google2fa');
        User::insert([
            ['uuid' => '12345', 'name' => 'Administrator Doe', 'mobile' => '0', 'role' => USER_ROLE_ADMIN, 'email' => 'admin@gmail.com', 'password' => Hash::make(123456), 'status' => USER_STATUS_ACTIVE, 'google2fa_secret' => $google2fa->generateSecretKey(), 'email_verification_status' => 1, 'phone_verification_status' => 1],
            ['uuid' => '123455', 'name' => 'User Doe', 'mobile' => '1', 'role' => USER_ROLE_USER, 'email' => 'user@gmail.com', 'password' => Hash::make(123456), 'status' => USER_STATUS_ACTIVE, 'google2fa_secret' => $google2fa->generateSecretKey(), 'email_verification_status' => 1, 'phone_verification_status' => 1],
        ]);
    }
}
