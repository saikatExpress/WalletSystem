<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $password = Hash::make('123456');

        User::insert([
            [
                'id'           => 1,
                'name'         => 'Admin',
                'email'        => 'admin@gmail.com',
                'phone_number' => '01713619765',
                'password'     => $password,
                'status'       => '1',
                'role'         => 'admin',
                'created_at'   => $now,
            ],
            [
                'id'           => 2,
                'name'         => 'Super Admin',
                'email'        => 'superadmin@gmail.com',
                'phone_number' => '01913619765',
                'password'     => $password,
                'status'       => '1',
                'role'         => 'super-admin',
                'created_at'   => $now,
            ],
        ]);

    }
}
