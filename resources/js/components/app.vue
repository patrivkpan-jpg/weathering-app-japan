<template>
	<div class="select-place-cont">
		<div v-for='(sPlace, iIndex) in aPlaces' @click='getPlace(sPlace), (iActiveIndex = iIndex)' class='select-place-weather' :class="[{'selected' : iActiveIndex === iIndex}, {'select-place-weather-disabled' : bBusy === true}]">
			<span>{{ sPlace }}</span>
		</div>
	</div>
	<div class="weather-details-cont"> 
		<table class="weather-details-table">
			<tr v-for='(oWeatherData, iIndex) in aWeatherData'>
				<td>
					{{ getDate(oWeatherData.dt_txt) }}
					<br>
					{{ getDay(oWeatherData.dt_txt) }}
					<br>
					{{ getTime(oWeatherData.dt_txt) }}
				</td>
				<td>
					<img :src="getWeatherIconLink(oWeatherData.weather[0].icon)" :alt="oWeatherData.weather[0].description">
				</td>
				<td>
					TEMP
					<br>
					{{ oWeatherData.main.temp }}°
				</td>
				<td>
					FEELS LIKE
					<br>
					{{ oWeatherData.main.feels_like }}°
				</td>
				<td>
					WIND
					<br>
					{{ oWeatherData.wind.speed }}m/s
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
				aWeatherData : [],
				iActiveIndex : 0,
				bBusy : false
			}
		},
		methods: {

			/**
			 * Get month, date, year from date
			 */
			getDate: function(sDate)
			{
				const aMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
				let sFormattedDate = new Date(sDate);
				return aMonths[sFormattedDate.getMonth()] + ' ' +  sFormattedDate.getDate() + ' ' + sFormattedDate.getFullYear();
			},

			/**
			 * Get day of the week from date
			 */
			getDay: function(sDate)
			{
				const aDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
				let sFormattedDate = new Date(sDate);
				return aDays[sFormattedDate.getDay()];
			},

			/**
			 * Get time from date
			 */
			getTime: function(sDate)
			{
				let sFormattedDate = new Date(sDate);
				let sTime = sFormattedDate.getHours();
				let sConvertedTime = (sTime > 12) ? (sTime - 12) : ((sTime === 0) ? 12 : sTime);
				return sConvertedTime + ((sTime < 12) ? 'AM' : 'PM');
			},

			getWeatherIconLink: function(sCode)
			{
				return 'https://openweathermap.org/img/wn/' + sCode + '@2x.png';
			},

			/**
			 * Get place data for latitude and longitude
			 */
			getPlace: function(sPlace)
			{
				this.bBusy = true;
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
						self.bBusy = false;
					}
				})
			}
		},
		mounted() {
			let self = this;
			this.$nextTick(function () {
				self.getPlace('Tokyo');
			})
		}
	}
</script>