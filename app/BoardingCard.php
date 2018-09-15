<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardingCard extends Model
{
    //
    public static function FetchAttrJourney($id)
    {
    	return BoardingCard::select('transport_name','seat','gate','baggage_drop')->where('id',$id)->get();
    }
}
