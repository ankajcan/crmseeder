<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('roles')->truncate();

        $rows[] = Role::create([ 'name' => 'Admin']);
        $rows[] = Role::create([ 'name' => 'User']);

        foreach($rows as $row) {
            $row->save();
        }
    }
}
