<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AcademicStaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = $this->faker->boolean();
        $gen = $gender == false ? 'female' : 'male';
        return [
            'name'=>Arr::last(explode('. ',$this->faker->name($gen))),
            'email'=>$this->faker->unique()->safeEmail(),
            'hashed_password'=>Hash::make('password'),
            'gender'=>$gender,
        ];
    }
}
