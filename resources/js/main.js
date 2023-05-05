$('.select-place-btn').click(getPlace);

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