<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Management',
            'days' => '30'
        ]);
        DB::table('categories')->insert([
            'name' => 'Senior',
            'days' => '25'
        ]);
        DB::table('categories')->insert([
            'name' => 'Junior',
            'days' => '20'
        ]);
    }
}
