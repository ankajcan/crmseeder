<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('countries')->truncate();

        \App\Models\Country::query()->truncate();

        DB::unprepared(File::get(base_path('database/seeds/sql/countries.sql')));
    }
}
