<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\GuzzleHelper;

class WeatherController extends Controller
{
	/**
	* Get place details
	* Used to get lat/long for getWeather
	**/
    public function getWeather(float $sLat, float $sLong)
    {
    	$sUrl = 'https://api.openweathermap.org/data/2.5/forecast?lat=' . $sLat . '&lon=' . $sLong . '&appid=dcca5aa68b3b6d3347b4cbbaa2e87fc6';

		return GuzzleHelper::request('GET', $sUrl);
    }
}
