<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define class names
        $classes = [
            ['name' => 'First Grade'],
            ['name' => 'Second Grade'],
            ['name' => 'Third Grade'],
            // Add more classes as needed
        ];

        // Insert data into the 'classes' table
        DB::table('classes')->insert($classes);
    }
}
