<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

//impoerting model trip
use App\Trip;
use App\BoardingCard;
use App\Journey;
use Schema;



class tripsController extends Controller
{
    public function index()
    {

    	if (Schema::hasTable('trips')) {
    	$Trips = Trip::all();
    	
    		return view('trips',compact("Trips"));
    	}else{
    		return view('instructions');
    	}
    }


    public function AddTrip(Request $request)
    {
		$trip = new Trip;

        $trip->name = $request->TripName;
        $trip->save();

        return redirect()->action('tripsController@index');
	}

		public function EnterDetails($id)
	{
		$tripID = $id;
        $trip = Trip::where('id',$tripID)->get();
        $card = BoardingCard::where('trip_id',$tripID)->count();
        
        // echo "<pre>";print_r($trip);exit;
        $name = $trip[0]->name;
		return view('boardingCard',compact('tripID','name','card'));

	}

	public function Addcard(Request $request)
	{
		
			if (isset($_REQUEST['submit'])){
				
				$card = new BoardingCard;

			        $card->name = $request->CardName;
			        $card->transport_name = $request->Trans_name;
			        $card->transport_type = $request->trans_type;
			        $card->trip_id = $request->tripID;
			        $card->seat = $request->Seatno;
			        $card->gate = $request->Gateno;
			        $card->baggage_drop = $request->BaggNo;

				        $chek = $card->save();
				        
				        if ($chek == true) {
					        		$boardingID =$card->id;

					        		$Journey = new Journey;

						        $Journey->DepartureDestination = $request->D_dest;
						        $Journey->finalDestination = $request->A_dest;
						        $Journey->trip_id = $request->tripID;
						        $Journey->boarding_id = $boardingID;
						        $Journey->transport_type = $request->trans_type;
				        	 	
				        	 		$chek = $Journey->save();

				        	 		if ($chek == true) {
	
					        	 		Trip::where('id', $request->tripID)->update(['status' => 1]);

				        	 			return redirect()->action('tripsController@EnterDetails',['id' => $request->tripID]);
				        	 		}
				        }
			}else{
				 return redirect()->action('tripsController@index');
			}
		
		// echo "<pre>";
		// print_r($_REQUEST);exit;
	}


}
