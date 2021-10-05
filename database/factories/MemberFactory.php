<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Member;
use App\Models\Score;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Member $member) {
            
            /** Checks if the member status is active and creates a random number of accounts (1,2) **/
            if($member->status === 'active'){

                $providers = ['Equifax', 'Experian'];
                $selectedProvider = $providers[array_rand($providers)]; /** Selects and stores the randomized provider from the $providers array **/

                Score::factory()->create([
                    'member_id' => $member->id,
                    'provider' => $selectedProvider,
                    'name' => ($selectedProvider === 'Equifax') ? $member->full_name : $member->partial_name,  /** Checks the selected provider Equifax = Full & Experian = First & Last only **/
                ]);

                Account::factory()->count(rand(1,2))->create(['member_id' => $member->id]);

            }
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ['active', 'partial', 'failed'];
        return [
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => $status[array_rand($status)],
        ];
    }
}
