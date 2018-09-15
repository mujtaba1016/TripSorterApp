<?php

use Illuminate\Database\Seeder;

class journeysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
          DB::table('journeys')->insert([
          	'id'=>'1',
            'DepartureDestination' => 'Madrid',
            'finalDestination' => 'Barcelona',
            'trip_id' => (1),
            'boarding_id' => (1),
            'transport_type' => 'Train',
        	]);
          DB::table('journeys')->insert([
          	'id'=>'2',
            'DepartureDestination' => 'Barcelona',
            'finalDestination' => 'Gerona',
            'trip_id' => (1),
            'boarding_id' => (2),
            'transport_type' => 'Bus',
        	]);
          DB::table('journeys')->insert([
          	'id'=>'3',
 			'DepartureDestination' => 'Gerona',
            'finalDestination' => 'Stockholm',
            'trip_id' => (1),
            'boarding_id' => (3),
            'transport_type' => 'Flight',
        	]);
           DB::table('journeys')->insert([
          	'id'=>'4',
 			'DepartureDestination' => 'Stockholm',
            'finalDestination' => 'NewYork',
            'trip_id' => (1),
            'boarding_id' => (4),
            'transport_type' => 'Flight',
        	]);
    }
}
