<?php

namespace Database\Seeders;

use App\Models\MajorSubject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MajorSubject::factory(50)->create();
    }
}
