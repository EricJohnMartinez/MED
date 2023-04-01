<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'email' => 'admin@mail.com'
        ], [
            'first_name' => 'Admin',
            'last_name' => 'CA',
            'email'=>'admin@mail.com',
            'password' => bcrypt('password'),
            'roles' => 'admin'
        ]);

        User::updateOrCreate([
            'email' => 'nurse@mail.com'
        ], [
            'first_name' => 'Nurse',
            'last_name' => 'Station',
            'email'=>'nurse@mail.com',
            'password' => bcrypt('password'),
            'roles' => 'nurse'
        ]);

        User::updateOrCreate([
            'email' => 'doctor@mail.com'
        ], [
            'first_name' => 'Doctor',
            'last_name' => ' ',
            'email'=>'doctor@mail.com',
            'password' => bcrypt('password'),
            'roles' => 'doctor'
        ]);

        User::updateOrCreate([
            'email' => 'pharmacy@mail.com'
        ], [
            'first_name' => 'Pharmacy',
            'last_name' => 'Station',
            'email'=>'pharmacy@mail.com',
            'password' => bcrypt('password'),
            'roles' => 'pharmacy'
        ]);
    }
}
