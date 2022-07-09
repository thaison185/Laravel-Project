<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            [
                'name'=>'Philosophy',
                'description'=>'General',
            ],
            [
                'name'=>'Psychology',
                'description'=>'General',
            ],
            [
                'name'=>'English',
                'description'=>'General',
            ],
            [
                'name'=>'Physical Education',
                'description'=>'General',
            ],
            [
                'name'=>'Jurisprudence',
                'description'=>'General',
            ],
            [
                'name'=>'Analytical Math',
                'description'=>null,
            ],
            [
                'name'=>'Discrete Math',
                'description'=>null,
            ],
            [
                'name'=>'Algebra',
                'description'=>null,
            ],
            [
                'name'=>'Physics',
                'description'=>null,
            ],
            [
                'name'=>'Math Logic and Theory of Algorithms',
                'description'=>null,
            ],
            [
                'name'=>'Economics',
                'description'=>null,
            ],
            [
                'name'=>'Computer Network',
                'description'=>null,
            ],
            [
                'name'=>'Data Structures and Algorithms',
                'description'=>null,
            ],
            [
                'name'=>'Number-theoretic Methods in Cryptography',
                'description'=>null,
            ],
            [
                'name'=>'Probability Statistics',
                'description'=>null,
            ],
            [
                'name'=>'Programming Languages',
                'description'=>null,
            ],
        ]);
    }
}
