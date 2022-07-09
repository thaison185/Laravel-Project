<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DepartmentSeeder::class,
            LecturerSeeder::class,
            MajorSeeder::class,
            SubjectSeeder::class,
            ClassSeeder::class,
            StudentSeeder::class,
            AcademicStaffSeeder::class,
        ]);
    }
}
