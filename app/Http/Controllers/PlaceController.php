<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PlaceController extends Controller
{
	/**
	* Get place details
	* Used to get lat/long for getWeather
	**/
    public function getPlace()
    {
    	$oGuzzle = new Client();
    	$oResponse = $oGuzzle->request('GET', 'https://api.foursquare.com/v3/places/search?near=Osaka%2C%20JP&limit=1', [
		  'headers' => [
		    'Authorization' => 'fsq3F6cFzv9rUyhZxJpc/gcqCvz7a7pLl90osR6+dWXc3Hs=',
		    'accept' => 'application/json',
		  ],
		]);

		$aDecodeRes = json_decode($oResponse->getBody()->getContents(), true);
		return $aDecodeRes;
    	// return 'Places API';
    }
}
