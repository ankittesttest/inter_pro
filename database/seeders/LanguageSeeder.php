<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define language names
        $languages = [
            ['languag_name' => 'English'],
            ['languag_name' => 'Hindi'],
            ['languag_name' => 'French'],
            // Add more languages as needed
        ];

        // Insert data into the 'languages' table
        DB::table('languages')->insert($languages);
    }
}
