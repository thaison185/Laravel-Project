<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    public function run()
    {
        DB::table('faculty')->insert([
            [
                'name'=>'IAMCS',
                'description' => 'Institute of Applied Mathematics and Computer Science - Viện Toán Ứng dụng và Khoa học Máy tính',
            ],
            [
                'name'=>'Physics and Chemistry',
                'description'=>'Khoa Vật lý và Hóa học',
            ],
            [
                'name'=>'Economics',
                'description'=>'Khoa Kinh tế',
            ],
            [
                'name'=>'Psychology',
                'description'=>'Khoa tâm lý học',
            ]
        ]);
    }
}
