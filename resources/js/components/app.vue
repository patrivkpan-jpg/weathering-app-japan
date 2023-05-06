<template>
	<div class="select-place-cont">
		<a v-for='(sPlace, iIndex) in aPlaces' @click='getPlace(sPlace), (iActiveIndex = iIndex)' class='select-place-weather' :class="[{'selected' : iActiveIndex === iIndex}, {'select-place-weather-disabled' : bBusy === true}]">
			<span>{{ sPlace }}</span>
		</a>
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
				// Selected city weather data
				aWeatherData : [],
				// Currently selected city anchor index
				iActiveIndex : 0,
				// Checker for button disable to prevent button spamming
				bBusy : false
			}
		},
		methods: {

			/**
			 * Get month, date, year from date
			 * @param {*} sDate 
			 */
			getDate: function(sDate)
			{
				const aMonths = [
					'January', 
					'February', 
					'March', 
					'April', 
					'May', 
					'June', 
					'July', 
					'August', 
					'September', 
					'October', 
					'November', 
					'December'
				];
				let sFormattedDate = new Date(sDate);
				return aMonths[sFormattedDate.getMonth()] 
				+ ' ' 
				+  sFormattedDate.getDate() 
				+ ' ' 
				+ sFormattedDate.getFullYear();
			},
			
			/**
			 * Get day of the week from date
			 * @param {*} sDate 
			 */
			getDay: function(sDate)
			{
				const aDays = [
					'Sunday', 
					'Monday', 
					'Tuesday', 
					'Wednesday', 
					'Thursday', 
					'Friday', 
					'Saturday'
				];
				let sFormattedDate = new Date(sDate);
				return aDays[sFormattedDate.getDay()];
			},

			/**
			 * Get time from date
			 * @param {*} sDate 
			 */
			getTime: function(sDate)
			{
				let sFormattedDate = new Date(sDate);
				let sTime = sFormattedDate.getHours();
				let sConvertedTime = (sTime > 12) ? (sTime - 12) : ((sTime === 0) ? 12 : sTime);
				return sConvertedTime 
				+ ((sTime < 12) ? 'AM' : 'PM');
			},

			/**
			 * Get icon for different weathers
			 * @param {*} sCode 
			 */
			getWeatherIconLink: function(sCode)
			{
				return 'https://openweathermap.org/img/wn/' + sCode + '@2x.png';
			},

			/**
			 * Get place data for latitude and longitude
			 * @param {*} sPlace 
			 */
			getPlace: function(sPlace)
			{
				this.bBusy = true;
				let self = this;
				$.ajax({
					url: '/api/place/' + sPlace,
					success: function(oRes, sStatus) {
						let oLatLong = oRes.context.geo_bounds.circle.center;
						self.getWeather(oLatLong.latitude, oLatLong.longitude);
					}
				})
			},

			/**
			 * Get weather data using latitude and longitude retrieved from getPlace
			 * @param {*} sLat 
			 * @param {*} sLong 
			 */
			getWeather: function(sLat, sLong)
			{
				let self = this;
				$.ajax({
					url: '/api/weather/' + sLat + '/' + sLong,
					success: function(oRes, sStatus) {
						self.aWeatherData = oRes.list;
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