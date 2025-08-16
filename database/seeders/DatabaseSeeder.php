<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Customer::factory()->count(10)->create();

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
        ]);
    }
}
