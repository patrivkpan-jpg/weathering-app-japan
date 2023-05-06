<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\GuzzleHelper;

class PlaceController extends Controller
{
	/**
	 * Get place details
	 * Used to get lat/long for getWeather
	 */
    public function getPlace(String $sPlace)
    {
    	$sUrl = 'https://api.foursquare.com/v3/places/search?near=' 
		. $sPlace 
		. '%%2C%%20JP&limit=1';
    	$aHeaders = [
			'headers' => [
		    	'Authorization' => 'fsq3F6cFzv9rUyhZxJpc/gcqCvz7a7pLl90osR6+dWXc3Hs=',
		    	'accept'        => 'application/json',
			]
		];

		return GuzzleHelper::request('GET', $sUrl, $aHeaders);
    }
}
