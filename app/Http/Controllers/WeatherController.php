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
    	$sAPIKey = env('OPEN_WEATHER_API_KEY', 'dcca5aa68b3b6d3347b4cbbaa2e87fc6');
    	$sUrl = 'https://api.openweathermap.org/data/2.5/forecast?lat=' . $sLat . '&lon=' . $sLong . '&appid=' . $sAPIKey;

		return GuzzleHelper::request('GET', $sUrl);
    }
}
