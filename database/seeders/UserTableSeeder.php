<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('qwerty'),
            'email_verified_at' => now(),
        ];

        User::create($user);
    }
}
