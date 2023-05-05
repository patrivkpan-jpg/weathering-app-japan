<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WeatherController extends Controller
{
	/**
	* Get place details
	* Used to get lat/long for getWeather
	**/
    public function getWeather(float $sLat, float $sLong)
    {
    	$oGuzzle = new Client();
    	$sUrl = 'https://api.openweathermap.org/data/2.5/forecast?lat=' . $sLat . '&lon=' . $sLong . '&appid=dcca5aa68b3b6d3347b4cbbaa2e87fc6';
    	$oResponse = $oGuzzle->request('GET', $sUrl, []);

		$aDecodeRes = json_decode($oResponse->getBody()->getContents(), true);
		return $aDecodeRes;
    }
}
