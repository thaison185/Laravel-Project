<?php

namespace Database\Seeders;

use App\Models\Classs;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classs::factory(30)->create();
    }
}
