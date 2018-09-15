<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;
use App\BoardingCard;
use App\Journey;
use DB;

class ApiController extends Controller
{
    
    public function index(Request $request)
    {
    	if($request->id){
    			$tripID = $request->id;

    		$data['trip'] = Trip::where('id',$tripID)->get();
        	
        	$BoardingCardIds = BoardingCard::select('id')->where('trip_id',$tripID)->get();

        		if (count($BoardingCardIds)>0) {

				// getting the journeys of specific boarding cards
	
				$journey = DB::table('journeys')->where('trip_id', $tripID)->get()->toArray();

					$json = json_encode($journey);
					$journey = json_decode($json, true);
					
					$journey = array_combine(array_map(function($value) {return $value['boarding_id'];}, $journey), array_map(function($value) {
						     return $value;
						}, $journey));
					
					// foreach ($journey as $card) {
					// 	$asoc[$card['finalDestination']] =$card; 
					// }
				
				//here we assumed the start of trip
				$trip[] =$journey[min(array_keys($journey))];
		      	unset($journey[min(array_keys($journey))]);
				
		      	$journey = array_values($journey);



				for ($i=0; $i < sizeof($trip) ; $i++) { 
					for ($j=0; $j < sizeof($journey); $j++) {
							if ($trip[$i]['finalDestination']==$journey[$j]['DepartureDestination']) {
							 		$trip[] =$journey[$j];
						      		unset($journey[$j]);
						      		$journey = array_values($journey);
									continue;
							 	} 
							
					}
				}
						 

		  //     	print_r($trip);
				// print_r($journey);exit;
		      		

				$Jcount = sizeof($journey);
						
						$list[]='<b>Your Trip</b>';
	        			
	        			//List generation of paired trips
	        			
	        			if (!empty($trip)) {
        					foreach ($trip as $sort) {
        						$info =  DB::select("SELECT transport_name,seat,gate,baggage_drop FROM `boarding_cards` where id =".$sort['boarding_id']);
        						$gate = ' ';
        						if($info[0]->gate != NULL){
        							$gate = 'Gate '.$info[0]->gate;
        						}
        						$Seat = ' ';
        						if($info[0]->gate != NULL){
        							$seat = 'Take seat no '.$info[0]->seat;
        						}else{
        							$seat = 'No seat Assignment';
        						}
        						$bag = ' ';
        						if($info[0]->gate != NULL){
        							$bag = 'Baggage Drop Counter no '.$info[0]->baggage_drop;
        						}

        						$list[] = 'Take '.$info[0]->transport_name.' '.$sort['transport_type'].' from <b>'.$sort['DepartureDestination'].' to '.$sort['finalDestination'].'</b> '.$gate.'.'.$seat.'.'.$bag;
        					}
        				}

	        			// List generation of paired trips
        				
        				// get the final destitnation of paired trip
        				$cP = count($trip) - 1;

        				if (!empty($journey)) 
        				{
							// here we add the missing trip which matches with last final destnation in paired 	
        					$list[] = 'There is a <b>missing trip</b> between <b><i>'.$trip[$cP]['finalDestination'].' to '.$journey[0]['DepartureDestination'].'</i></b>';
        					
        					for($i=0;$i<count($journey);$i++)
        					{
        							$info =  DB::select("SELECT transport_name,seat,gate,baggage_drop FROM `boarding_cards` where id =".$journey[$i]['boarding_id']);
        						$gate = ' ';
        						if($info[0]->gate != NULL){
        							$gate = 'Gate '.$info[0]->gate;
        						}
        						$Seat = ' ';
        						if($info[0]->gate != NULL){
        							$seat = 'Take seat no '.$info[0]->seat;
        						}else{
        							$seat = 'No seat Assignment';
        						}
        						$bag = ' ';
        						if($info[0]->gate != NULL){
        							$bag = 'Baggage Drop Counter no '.$info[0]->baggage_drop;
        						}

        						if ($i>0 and $journey[($i-1)]['finalDestination'] != $journey[$i]['DepartureDestination']) {
        							$list[] = 'There is a <b>missing trip</b> between <b><i>'.$journey[$i-1]['finalDestination'].' to '.$journey[$i]['DepartureDestination'].'</i></b>';
        						}
        						$list[] = 'Take '.$info[0]->transport_name.' '.$journey[$i]['transport_type'].' from <b>'.$journey[$i]['DepartureDestination'].'</b> to <b>'.$journey[$i]['finalDestination'].'</b> '.$gate.'.'.$seat.'.'.$bag;
        					}
        				}


        				
       //  				echo "<pre> Paired";print_r($trip);
       //  				echo "<br><br>";
       //  				echo "<pre> UnPaired";print_r($journey);exit;
						 // // "<pre>";print_r($list);	
        				// exit;
        				
        					$response['status'] = '200';
							$response['status_message'] = 'List Sorted';
							$response['List'] = $list;
					    	return response()->json($response);
        				}else{
        					$empty[] = '<b>There is no card in tray.</b>	'; 	
        					$response['status'] = '200';
							$response['status_message'] = 'List Sorted';
							$response['List'] = $empty;
					    	return response()->json($response);
        				}
	        			
    
					    }else{
					    	$response['status'] = '404';
							$response['status_message'] = 'Something Bad';
							$response['List'] = 'Sorry';
					    	return response()->json($response);
					    }
	}


	
}
    	
