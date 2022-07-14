<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('majors')->insert([
            [
                'name'=>'Computer Science',
                'faculty_id'=>1,
                'degree'=>0,
            ],
            [
                'name'=>'Software Engineering',
                'faculty_id'=>1,
                'degree'=>0,
            ],
            [
                'name'=>'Applied Informatics',
                'faculty_id'=>1,
                'degree'=>0,
            ],
            [
                'name'=>'Information Security',
                'faculty_id'=>1,
                'degree'=>1,
            ],
            [
                'name'=>'Robotics and Automation',
                'faculty_id'=>1,
                'degree'=>0,
            ],
            [
                'name'=>'Nuclear Engineering',
                'faculty_id'=>2,
                'degree'=>1,
            ],
            [
                'name'=>'Meteorology – Hydrology',
                'faculty_id'=>2,
                'degree'=>0,
            ],
            [
                'name'=>'Materials Science and Nanotechnology',
                'faculty_id'=>2,
                'degree'=>2,
            ],
            [
                'name'=>'Optics and Optoelectronic',
                'faculty_id'=>2,
                'degree'=>3,
            ],
            [
                'name'=>'Human Resources Management',
                'faculty_id'=>3,
                'degree'=>0,
            ],
            [
                'name'=>'Foreign Economic Relations',
                'faculty_id'=>3,
                'degree'=>0,
            ],
            [
                'name'=>'Logistics and Supply Chain Management',
                'faculty_id'=>3,
                'degree'=>0,
            ],
            [
                'name'=>'Business Administration',
                'faculty_id'=>3,
                'degree'=>0,
            ],
            [
                'name'=>'Marketing',
                'faculty_id'=>4,
                'degree'=>0,
            ],
            [
                'name'=>'Advertising and Public Relations',
                'faculty_id'=>4,
                'degree'=>0,
            ],
        ]);
    }
}
