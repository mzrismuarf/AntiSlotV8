<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $user = User::create([
            'name'              => 'Admin',
            'email'             => 'antislot@ac.id',
            'email_verified_at' => 'antislot@ac.id',
            'password'          =>  bcrypt('@Antislot1337')
        ]);

        $this->command->info('Data User ' . $user->name . ' has been saved.');
    }
}
