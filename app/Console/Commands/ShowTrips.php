<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Trip;
use App\BoardingCard;
use Schema;


class ShowTrips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ShowTrips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show Trips added to the system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Schema::hasTable('trips')) {
        $trips = Trip::all();
        
        if (count($trips) > 0) {
            $this->info("\n".'Total Trips in system: '.count($trips)."\n");
            foreach ($trips as $trip) {
                $cards = BoardingCard::where('trip_id',$trip->id)->count();
                $this->info("\n".'Trip Name: '.$trip->name."\n".' Trip Id: '.$trip->id.' Cards added for this trip = '.$cards."\n");
                }
            
        }else{
        
            $this->info("\n".'No Trip in system.'."\n");

        }
    }else{
            $this->info('No DB structure found in system. '."\n".'Please migrate first.');
        }

    }
}
