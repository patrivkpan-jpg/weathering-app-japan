<template>
	<h1>Japan Weathering App</h1>
	<span>Which place do you want to check the weather?</span>
	<br><br><br>
	<span v-for='sPlace in aPlaces' @click='getPlace(sPlace)'>{{ sPlace }}</span>
	<br><br><br>
	<div>
		<table>
			<tr v-for='(oWeatherData, iIndex) in aWeatherData'>
				<td>
					{{ formatDate(oWeatherData.dt_txt) }}
				</td>
				<td>
					{{ oWeatherData.weather[0].main }}
				</td>
				<td>
					Temp : {{ oWeatherData.main.temp }}°
				</td>
				<td>
					Feels like : {{ oWeatherData.main.feels_like }}°
				</td>
				<td>
					Wind : {{ oWeatherData.wind.speed }}m/s
				</td>
			</tr>
		</table>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				aPlaces : [
					'Tokyo',
					'Yokohama',
					'Kyoto',
					'Osaka',
					'Sapporo',
					'Nagoya'
				],
				aWeatherData : []
			}
		},
		methods: {

			formatDate: function(sDate)
			{
				const aDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
				const aMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
				let sFormattedDate = new Date(sDate);
				let sTime = sFormattedDate.getHours();
				let sConvertedTime = (sTime > 12) ? (sTime - 12) : ((sTime === 0) ? 12 : sTime);
				return aDays[sFormattedDate.getDay()] + ' ' + aMonths[sFormattedDate.getMonth()] + ' ' +  sFormattedDate.getDate() + ' ' + sFormattedDate.getFullYear() + ' ' + sConvertedTime + ((sTime < 12) ? 'AM' : 'PM');
			},
			/**
			* Get weather data using latitude and longitude
			*/
			getWeather: function(sLat, sLong)
			{
				let self = this;
				$.ajax({
					url: '/api/weather/' + sLat + '/' + sLong,
					success: function(oRes, sStatus) {
						self.aWeatherData = oRes.list;
						console.log(self.aWeatherData)
					}
				})
			},

			/**
			* Get place data for latitude and longitude
			**/
			getPlace: function(sPlace)
			{
				let self = this;
				$.ajax({
					url: '/api/place/' + sPlace,
					success: function(oRes, sStatus) {
						let oLatLong = oRes.context.geo_bounds.circle.center;
						console.log(oLatLong['latitude'], oLatLong['longitude']);
						self.getWeather(oLatLong.latitude, oLatLong.longitude);
					}
				})
			},
		}
	}
</script>