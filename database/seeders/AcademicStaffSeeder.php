<?php

namespace Database\Seeders;

use App\Models\AcademicStaff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AcademicStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcademicStaff::factory(1)->create([
            'role'=>true,
            'email'=>'fakeadmin@example.com',
            'password'=>Hash::make('backdoor'),
            ]);
        AcademicStaff::factory(14)->create();
    }
}
