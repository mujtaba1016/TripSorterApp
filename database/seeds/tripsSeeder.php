<?php

use Illuminate\Database\Seeder;

class tripsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('trips')->insert([
            'name' => str_random(5),
            'status' => (1),
        	]);
    }
}
