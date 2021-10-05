<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Score;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Score::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'member_id' => Member::factory(),
            'value' => rand(0, 900),
            'provider' => Member::factory(),
            'name' => Member::factory(),
        ];
    }
}
