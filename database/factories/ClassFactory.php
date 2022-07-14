<?php

namespace Database\Factories;

use App\Models\Classs;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Classs::class;
    public function definition()
    {
        $admission_year = $this->faker->dateTimeBetween('-10 years','now');
        $yy = $admission_year->format('y');
        $YY = $admission_year->format('Y');
        $department = $this->faker->numberBetween(1,4);
        switch ($department){
            case 1:
                $major = $this->faker->numberBetween(1,5);
                break;
            case 2:
                $major = $this->faker->numberBetween(6,9);
                break;
            case 3:
                $major = $this->faker->numberBetween(10,13);
                break;
            case 4:
                $major = $this->faker->numberBetween(14,15);
                break;
        }

        return [
            'name'=>'0'. $department . ($major<10?'0'. $major : $major) . $yy . '0' . $this->faker->numberBetween(1,4),
            'admission_year'=> $YY,
            'major_id'=>$major,
        ];
    }
}
