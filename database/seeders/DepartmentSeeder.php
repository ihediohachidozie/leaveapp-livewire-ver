<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = ['infotech', 'hr & admin', 'commercials', 'operations', 'hseq', 'finance & accounting', 'security', 'compliance', 'logistics', 'store', 'procurement'];
        
        foreach( $departments as $department)
        {
            DB::table('departments')->insert([
                'name' => $department,
                'company_id' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
