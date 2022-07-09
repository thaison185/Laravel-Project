<?php

namespace Database\Seeders;

use App\Models\AcademicStaff;
use Illuminate\Database\Seeder;

class AcademicStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcademicStaff::factory(5)->create();
    }
}
