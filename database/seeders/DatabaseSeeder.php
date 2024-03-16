<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ClinicProfile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        ClinicProfile::factory()->create([
            'name' => 'E-Klinik',
            'address' => 'Jl.insyallah Barokah',
            'phone' => '082345672937',
            'email' => 'asd@gmail.com',
            'doctor_name' => 'Mazrul .K',
            'unique_code' => '354313'
        ]);

        $this->call([
            DoctorsSeeder::class,
            RoleSeeder::class,
            DoctorScheduleSeeder::class
        ]);
    }
}
