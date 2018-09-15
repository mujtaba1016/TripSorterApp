<?php
/**
 * @SWG\Swagger(
 *   basePath="/api",
 *   @SWG\Info(
 *     title="Trips Sorter API",
 *     version="1.0.0"
 *   )
 * )
 */

/**
 * @SWG\Get(
 *   path="/sort_api/{id}/{format}",
 *   summary="Get your Trip Sorted w.r.t Boarding Cards",
 *   operationId="Get Sorted trip Against your tripID",
 *   @SWG\Parameter(
 *     name="id",
 *     in="path",
 *     description="Target TripID",
 *     required=false,
 *     type="integer"
 *   ),
 *   @SWG\Parameter(
 *     name="format",
 *     in="path",
 *     description="Format for which list to be sorted",
 *     required=false,
 *     enum={"cli", "web"},
 *     type="string"
 *   ),
 *   @SWG\Response(response=200, description="successful operation"),
 *   @SWG\Response(response=406, description="not acceptable"),
 *   @SWG\Response(response=500, description="internal server error")
 * )
 *
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;
use App\BoardingCard;
use App\Journey;


class ApiController extends Controller
{
    
    public function index(Request $request)
    {
    	if($request->id){
    			$tripID = $request->id;
                $format = $request->format;

               

    		$data['trip'] = Trip::where('id',$tripID)->get();
        	
        	$BoardingCardIds = BoardingCard::select('id')->where('trip_id',$tripID)->get();

        		if (count($BoardingCardIds)>0) {

				// getting the journeys of specific boarding cards
	
					$journey = Journey::select()->where('trip_id', $tripID)->get()->toArray();

					$json = json_encode($journey);
					$journey = json_decode($json, true);
					
					$journey = array_combine(array_map(function($value) {return $value['boarding_id'];}, $journey), array_map(function($value) {
						     return $value;
						}, $journey));
					
					
					//here we assumed the start of trip
					$trip[] =$journey[min(array_keys($journey))];
			      	unset($journey[min(array_keys($journey))]);
					
			      	$journey = array_values($journey);


			      	//here is the algorithm which sorts the trip[] array according to requirement
						for ($i=0; $i < sizeof($trip) ; $i++) { 
							$pair = array_search($trip[$i]['finalDestination'],(array_column($journey, 'DepartureDestination')));
								if (false !== $pair) {
									$trip[] =$journey[$pair];
						      		unset($journey[$pair]);
						      		$journey = array_values($journey);
								}
						}
				      		
						$Jcount = sizeof($journey);
						
						
	        			
	        			//List generation of paired trips
	        			
	        			if (!empty($trip) AND $format == 'web') {
                            $list[]='<b>Your Trip</b>';
        					foreach ($trip as $sort) {
        						$info =  BoardingCard::FetchAttrJourney($sort['boarding_id']);
        						$gate = ' ';
        						if($info[0]->gate != NULL){
        							$gate = 'Gate '.$info[0]->gate;
        						}
        						$Seat = ' ';
        						if($info[0]->seat != NULL){
        							$seat = 'Take seat no '.$info[0]->seat;
        						}else{
        							$seat = 'No seat Assignment';
        						}
        						$bag = ' ';
        						if($info[0]->baggage_drop != NULL){
        							$bag = 'Baggage Drop Counter no '.$info[0]->baggage_drop;
        						}

        						$list[] = 'Take '.$info[0]->transport_name.' '.$sort['transport_type'].' from <b>'.$sort['DepartureDestination'].' to '.$sort['finalDestination'].'</b> '.$gate.'.'.$seat.'.'.$bag;
        					}
        				}

                        if (!empty($trip) AND $format == 'cli') {
                            $list[]='Your Trip';
                            foreach ($trip as $sort) {
                                $info =  BoardingCard::FetchAttrJourney($sort['boarding_id']);
                                $gate = ' ';
                                if($info[0]->gate != NULL){
                                    $gate = 'Gate '.$info[0]->gate;
                                }
                                $Seat = ' ';
                                if($info[0]->seat != NULL){
                                    $seat = 'Take seat no '.$info[0]->seat;
                                }else{
                                    $seat = 'No seat Assignment';
                                }
                                $bag = ' ';
                                if($info[0]->baggage_drop != NULL){
                                    $bag = 'Baggage Drop Counter no '.$info[0]->baggage_drop;
                                }

                                $list[] = 'Take '.$info[0]->transport_name.' '.$sort['transport_type'].' from '.$sort['DepartureDestination'].' to '.$sort['finalDestination'].' '.$gate.'.'.$seat.'.'.$bag;
                            }
                        }

                         if (!empty($trip) AND ($format != 'cli') AND ($format != 'web')) 
                        {
                            // here we add the missing trip which matches with last final destnation in paired  
                            $list[] = 'Something Bad in Api Calling.';
                            
                        }
	        			// List generation of paired trips
        				
        				// get the final destitnation of paired trip
        				$cP = count($trip) - 1;

        				if (!empty($journey) AND $format == 'web') 
        				{
							// here we add the missing trip which matches with last final destnation in paired 	
        					$list[] = 'There is a <b>missing trip</b> between <b><i>'.$trip[$cP]['finalDestination'].' to '.$journey[0]['DepartureDestination'].'</i></b>';
        					
        					for($i=0;$i<count($journey);$i++)
        					{
        							$info =  BoardingCard::FetchAttrJourney($journey[$i]['boarding_id']);
        						$gate = ' ';
        						if($info[0]->gate != NULL){
        							$gate = 'Gate '.$info[0]->gate;
        						}
        						$Seat = ' ';
        						if($info[0]->seat != NULL){
        							$seat = 'Take seat no '.$info[0]->seat;
        						}else{
        							$seat = 'No seat Assignment';
        						}
        						$bag = ' ';
        						if($info[0]->baggage_drop != NULL){
        							$bag = 'Baggage Drop Counter no '.$info[0]->baggage_drop;
        						}

        						if ($i>0 and $journey[($i-1)]['finalDestination'] != $journey[$i]['DepartureDestination']) {
        							$list[] = 'There is a <b>missing trip</b> between <b><i>'.$journey[$i-1]['finalDestination'].' to '.$journey[$i]['DepartureDestination'].'</i></b>';
        						}
        						$list[] = 'Take '.$info[0]->transport_name.' '.$journey[$i]['transport_type'].' from <b>'.$journey[$i]['DepartureDestination'].'</b> to <b>'.$journey[$i]['finalDestination'].'</b> '.$gate.'.'.$seat.'.'.$bag;
        					}
        				}

                        if (!empty($journey) AND $format == 'cli') 
                        {
                            // here we add the missing trip which matches with last final destnation in paired  
                            $list[] = 'There is a missing trip between '.$trip[$cP]['finalDestination'].' to '.$journey[0]['DepartureDestination'].'.';
                            
                            for($i=0;$i<count($journey);$i++)
                            {
                                    $info =  BoardingCard::FetchAttrJourney($journey[$i]['boarding_id']);
                                $gate = ' ';
                                if($info[0]->gate != NULL){
                                    $gate = 'Gate '.$info[0]->gate;
                                }
                                $Seat = ' ';
                                if($info[0]->seat != NULL){
                                    $seat = 'Take seat no '.$info[0]->seat;
                                }else{
                                    $seat = 'No seat Assignment';
                                }
                                $bag = ' ';
                                if($info[0]->baggage_drop != NULL){
                                    $bag = 'Baggage Drop Counter no '.$info[0]->baggage_drop;
                                }

                                if ($i>0 and $journey[($i-1)]['finalDestination'] != $journey[$i]['DepartureDestination']) {
                                    $list[] = 'There is a missing trip between '.$journey[$i-1]['finalDestination'].' to '.$journey[$i]['DepartureDestination'].'.';
                                }
                                $list[] = 'Take '.$info[0]->transport_name.' '.$journey[$i]['transport_type'].' from '.$journey[$i]['DepartureDestination'].' to '.$journey[$i]['finalDestination'].' '.$gate.'.'.$seat.'.'.$bag;
                            }
                        }

                        if (!empty($journey) AND ($format != 'cli') AND ($format != 'web')) 
                        {
                            // here we add the missing trip which matches with last final destnation in paired  
                            $list[] = 'Something Bad in Api Calling.';
                            
                        }

        				
        					$response['status'] = '200';
							$response['status_message'] = 'List Sorted';
							$response['List'] = $list;
					    	return response()->json($response);
        				}else{
        					$empty[] = 'There is no card in tray.'; 	
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
    	
