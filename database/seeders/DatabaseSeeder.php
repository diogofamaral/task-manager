<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $john = User::factory()->create([
             'name' => 'John Doe',
             'email' => 'john@email.com',
         ]);

        $jane = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@email.com',
        ]);

        Task::factory(50)->create([
            'user_id' => $john->id,
        ]);

        Task::factory(50)->create([
            'user_id' => $jane->id,
        ]);
    }
}
