<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Trip;


class AddTrip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AddTrip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add trips';

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
        $this->info('Add Your Trip');
        $name = $this->ask('Please enter the trip name?');
        
        $trip = new Trip;
        $trip->name = $name;
        $save = $trip->save();
        if($save == true){
        $this->info('Your Trip "'.$name.'" added sucessfully');
    }else{
        $this->info('Something bad.Try again');
        }
    }
}
