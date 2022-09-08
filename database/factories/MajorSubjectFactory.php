<?php

namespace Database\Factories;

use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class MajorSubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $majors = Major::all()->pluck('id');
        $subjects = [1,2,3,4,5];
        $matrix = $majors->crossJoin($subjects);
        $unique_set = $this->faker->unique()->randomElement($matrix);
        return [
            'major_id'=>$unique_set[0],
            'subject_id'=>$unique_set[1],
            'semester'=>1,
            'lecture_hour'=>$this->faker->numberBetween(100,300),
        ];
    }
}
