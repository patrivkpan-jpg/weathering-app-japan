<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<html>
    <div>
    	<h1>JAPAN SAIKO!</h1>
        This is the weathering app!
    </div>
    <br>
    <div>
		Which place do you want to check the weather?
		@php
			$aPlaces = [
				'Tokyo',
				'Yokohama',
				'Kyoto',
				'Osaka',
				'Sapporo',
				'Nagoya'
			];
		@endphp
		<br>
		@foreach ($aPlaces as $sPlace)
    		<button class="select-place-btn" data-place='{{ $sPlace }}'>{{ $sPlace }}</button>
		@endforeach
    </div>
</html>
<script>
	$('.select-place-btn').click(getPlace());

	/**
	* Get place data for latitude and longitude
	**/
	function getPlace()
	{
		$.ajax({
			url: '/api/place/' + $(this).attr('data-place'),
			success: function(oRes, sStatus) {
				let oLatLong = oRes['context']['geo_bounds']['circle']['center'];
				console.log(oLatLong['latitude'], oLatLong['longitude']);
				getWeather(oLatLong['latitude'], oLatLong['longitude']);
			}
		})
	}

	/**
	* Get weather data using latitude and longitude
	*/
	function getWeather(sLat, sLong)
	{
		$.ajax({
			url: '/api/weather/' + sLat + '/' + sLong,
			success: function(oRes, sStatus) {
				console.log(oRes)
			}
		})

	}

</script>
