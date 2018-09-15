<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\BoardingCard;
use App\Trip;
use App\Journey;



class AddCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AddCard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Boarding Cards';

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
        $this->info('Add Your Card');
        
        $trip_id = $this->ask('Please enter the Trip Id for which you want to Add Boarding Card?');
        $find_trip = Trip::find($trip_id);
       if (count($find_trip) == 1) 
       {

            $name = $this->ask('Please enter the card name?');
            $transport_type = $this->choice('Please select the Transport type?', ['Bus', 'Train','Flight']);
            $transport_name = $this->ask('Please enter the Transport name?');
            $departure = $this->ask('Please enter the Departure mentioned on card?');
            $arrival = $this->ask('Please enter the Arrival mentioned on card?');
            $gate = NULL;
            $seat = NULL;
            $bag = NULL;

                if ($transport_type == 'Train') {
                        $seat = $this->ask('Please enter the Seat No for Train?');
                    }
                if ($transport_type == 'Flight') {
                        $seat = $this->ask('Please enter the Seat No for Flight?');
                        $gate = $this->ask('Please enter the Gate No for Flight?');
                        $bag = $this->ask('Please enter the Baggage drop Counter No for Flight?');
                    }

                    $card = new BoardingCard;

                    $card->name = $name;
                    $card->transport_name = $transport_name;
                    $card->transport_type = $transport_type;
                    $card->trip_id = $trip_id;
                    $card->seat = $seat;
                    $card->gate = $gate;
                    $card->baggage_drop = $bag;

                        $chek = $card->save();
                                
                                if ($chek == true) {
                                    $boardingID =$card->id;

                                $Journey = new Journey;

                                $Journey->DepartureDestination = $departure;
                                $Journey->finalDestination = $arrival;
                                $Journey->trip_id = $trip_id;
                                $Journey->boarding_id = $boardingID;
                                $Journey->transport_type = $transport_type;
                                
                                    $chek = $Journey->save();

                                    if ($chek == true) {
    
                                        Trip::where('id', $trip_id)->update(['status' => 1]);

                                        $this->info('Card is added sucessfully for Trip ID:'.$trip_id);exit;
                                        
                                    }
                                }
                                
                                    
       }else{
        $this->info('Trip Id is not Valid. Try Again');exit;
       }
        
    }   

}
