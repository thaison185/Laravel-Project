<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lecturer::factory(1)->create([
            'email'=>'fakelecturer@example.com',
            'password'=>Hash::make('backdoor'),
        ]);
        Lecturer::factory(24)->create();
    }
}
