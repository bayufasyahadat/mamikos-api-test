<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed Role Owner,Regular User,Premium User,

        $owner = Role::create(['name' => 'Owner']);
        $reg_user = Role::create(['name' => 'Regular User']);
        $prem_user = Role::create(['name' => 'Premium User']);

    }
}
