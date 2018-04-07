<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::where("email", "admin@admin.com")->first();

        if(!$user) {
            $user = factory(\App\Models\User::class)->create(['email' => 'admin@admin.com']);

            $user->assignRole('Admin');
        }

    }
}
