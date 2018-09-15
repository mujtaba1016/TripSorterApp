<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(tripsSeeder::class);
         $this->call(boarding_cardsSeeder::class);
         $this->call(journeysSeeder::class);

    }
}
