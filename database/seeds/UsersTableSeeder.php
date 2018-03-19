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
        \Illuminate\Support\Facades\DB::table('users')->truncate();

        $user = factory(\App\Models\User::class)->create(['email' => 'admin@admin.com']);

        $user->assignRole('Admin');

    }
}
