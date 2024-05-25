<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::factory()->create([
            'name' => 'admin',
        ]);

        Role::factory()->create([
            'name' => 'student',
        ]);

        User::factory()->create([
            'name' => 'Admin Account',
            'username' => 'admin',
            'NIM' => '1234567890',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Test No. 1',
            'rt_number' => 1,
            'rw_number' => 1,
            'village' => 'Test Village',
            'district' => 'Test District',
            'city' => 'Test City',
            'province' => 'Test Province',
            'phone_number' => '081234567890',
            'hobby' => 'Test Hobby',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Admin Account 2',
            'username' => 'admin2',
            'NIM' => '1234567890222',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Test No. 1',
            'rt_number' => 1,
            'rw_number' => 1,
            'village' => 'Test Village',
            'district' => 'Test District',
            'city' => 'Test City',
            'province' => 'Test Province',
            'phone_number' => '081234567890',
            'hobby' => 'Test Hobby',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Student Account',
            'username' => 'student',
            'NIM' => '0987654321',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Test No. 2',
            'rt_number' => '02',
            'rw_number' => '04',
            'village' => 'Test Village',
            'district' => 'Test District',
            'city' => 'Test City',
            'province' => 'Test Province',
            'phone_number' => '081234567890',
            'hobby' => 'Test Hobby',
            'password' => bcrypt('password'),
            'role_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'Real Student Account',
            'username' => 'realstudent',
            'NIM' => '0987654322',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Ir H. Juanda No.95',
            'rt_number' => '02',
            'rw_number' => '04',
            'village' => 'Ciputat',
            'district' => 'Ciputat Timur',
            'city' => 'Tangerang Selatan',
            'province' => 'Banten',
            'phone_number' => '081234567890',
            'hobby' => 'Test Hobby',
            'password' => bcrypt('password'),
            'role_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'Dayat',
            'username' => 'dayat',
            'NIM' => '0987654',
            'date_of_birth' => '2000-01-01',
            'address' => 'Jalan Perapatan Padang',
            'rt_number' => '06',
            'rw_number' => '07',
            'village' => 'Jatsari',
            'district' => 'Jatiasih',
            'city' => 'Bekasi',
            'province' => 'Jawa Barat',
            'phone_number' => '081234567890',
            'hobby' => 'Test Hobby',
            'password' => bcrypt('password'),
            'role_id' => 2,
        ]);
    }
}
