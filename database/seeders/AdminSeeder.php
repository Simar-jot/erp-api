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
        $admins = $this->adminDetails();
        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make($admin['password']), 
                    'role' => $admin['role'],
                ]
            );
        }
    }

    public function adminDetails()
    {
        return [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => 'Admin@123', // raw password
                'role' => 'admin',
            ]
        ];
    }
}
