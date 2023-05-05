<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GuzzleHelper
{
	public static function request(String $sMethod, String $sUrl, array $aHeaders = [])
	{
    	$oGuzzle = new Client();
    	$oResponse = $oGuzzle->request($sMethod, $sUrl, $aHeaders);

		$aDecodeRes = json_decode($oResponse->getBody()->getContents(), true);
		return $aDecodeRes;
	}
}
