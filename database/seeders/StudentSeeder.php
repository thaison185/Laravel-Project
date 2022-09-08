<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::factory(1)->create([
            'email'=>'fakestudent@example.com',
            'password'=>Hash::make('backdoor'),
        ]);
        Student::factory(99)->create();
    }
}
