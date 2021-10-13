<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'infotech'
        ]);
        DB::table('departments')->insert([
            'name' => 'hr & admin'
        ]);
        DB::table('departments')->insert([
            'name' => 'commercials'
        ]);
        DB::table('departments')->insert([
            'name' => 'opterations'
        ]);
        DB::table('departments')->insert([
            'name' => 'logistics'
        ]);
    }
}
