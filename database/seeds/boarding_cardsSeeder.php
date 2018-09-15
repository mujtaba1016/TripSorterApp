<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class boarding_cardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('boarding_cards')->insert([
            'id' => '1',
            'name' => 'Abc',
            'seat' => '55',
            'gate' => NULL,
            'baggage_drop' => NULL,
            'transport_name' => '78A',
            'transport_type' => 'Train',
            'trip_id' => (1),
        	]);
         DB::table('boarding_cards')->insert([
            'id' => '2',
            'name' => 'def',
            'seat' => NULL,
            'gate' => NULL,
            'baggage_drop' => NULL,
            'transport_name' => 'Airport Bus',
            'transport_type' => 'Bus',
            'trip_id' => (1),
        	]);
         DB::table('boarding_cards')->insert([
            'id' => '3',
            'name' => 'ghi',
            'seat' => '45B',
            'gate' => '3A',
            'baggage_drop' => '344',
            'transport_name' => 'Flight SK455',
            'transport_type' => 'flight',
            'trip_id' => (1),
        	]);
         DB::table('boarding_cards')->insert([
            'id' => '4',
            'name' => 'jkl',
            'seat' => '7B',
            'gate' => '22',
            'baggage_drop' => NULL,
            'transport_name' => 'Flight SK22',
            'transport_type' => 'flight',
            'trip_id' => (1),
        	]);
    }
}
