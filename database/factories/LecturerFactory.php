<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class LecturerFactory extends Factory
{

    public function definition()
    {
        $gender = $this->faker->boolean();
        $gen = $gender == false ? 'female' : 'male';
        return [
            'name'=>Arr::last(explode('. ',$this->faker->name($gen))),
            'email'=>$this->faker->unique()->safeEmail(),
            'hashed_password'=>Hash::make('password'),
            'DoB'=>$this->faker->date($format = 'Y-m-d', $max = '-24 years'),
            'gender'=>$gender,
            'faculty_id'=>$this->faker->numberBetween(1,4),
        ];
    }
}
