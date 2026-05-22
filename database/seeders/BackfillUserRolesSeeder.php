<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BackfillUserRolesSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->call('users:backfill-roles', ['--force' => true]);
    }
}
