<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class StudentFactory extends Factory
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
            'password'=>Hash::make('password'),
            'DoB'=>$this->faker->date($format = 'Y-m-d', $max = '-24 years'),
            'gender'=>$gender,
            'class_id'=>$this->faker->numberBetween(1,30),
            'phone'=>$this->faker->phoneNumber(),
        ];
    }
}
