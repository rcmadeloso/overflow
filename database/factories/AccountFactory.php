<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ['open', 'closed'];
        return [
            'member_id' => Member::factory(),
            'account_number' => $this->faker->numerify('############'),
            'account_status' => $status[array_rand($status)],
            'account_balance' => $this->faker->numberBetween(0, 99999),
        ];
    }
}
