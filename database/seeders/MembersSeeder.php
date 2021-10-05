<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Member;
use App\Models\Score;
use Illuminate\Database\Seeder;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::factory()->count(10)->create();
    }
}
