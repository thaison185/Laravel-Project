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
                'department_id'=>1,
            ],
            [
                'name'=>'Software Engineering',
                'department_id'=>1,
            ],
            [
                'name'=>'Applied Informatics',
                'department_id'=>1,
            ],
            [
                'name'=>'Information Security',
                'department_id'=>1,
            ],
            [
                'name'=>'Robotics and Automation',
                'department_id'=>1,
            ],
            [
                'name'=>'Nuclear Engineering',
                'department_id'=>2,
            ],
            [
                'name'=>'Meteorology – Hydrology',
                'department_id'=>2,
            ],
            [
                'name'=>'Materials Science and Nanotechnology',
                'department_id'=>2,
            ],
            [
                'name'=>'Optics and Optoelectronic',
                'department_id'=>2,
            ],
            [
                'name'=>'Human Resources Management',
                'department_id'=>3,
            ],
            [
                'name'=>'Foreign Economic Relations',
                'department_id'=>3,
            ],
            [
                'name'=>'Logistics and Supply Chain Management',
                'department_id'=>3,
            ],
            [
                'name'=>'Business Administration',
                'department_id'=>3,
            ],
            [
                'name'=>'Marketing',
                'department_id'=>4,
            ],
            [
                'name'=>'Advertising and Public Relations',
                'department_id'=>4,
            ],
        ]);
    }
}
