<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = ['De Royce Solutions', 'ECM Terminals Ltd', 'ECM Terminals Oil & Gas Logistics Ltd', 'Daddo Maritime Services', 'Shipping & Terminals Logistics'];

        foreach($companies as $company)
        {
            DB::table('companies')->insert([
                'name' => $company,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    
            ]);
        }
    }
}
