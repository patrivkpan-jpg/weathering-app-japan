<template>
	<h1>{{ sHeader }}</h1>
	<span>Which place do you want to check the weather?</span>
	<br>
	<button v-for='sPlace in aPlaces' @click='getPlace(sPlace)' class="select-place-btn" data-place='{{ sPlace }}'>{{ sPlace }}</button>
</template>

<script>
	export default {
		data() {
			return {
				sHeader : 'Japan Weathering App',
				aPlaces : [
					'Tokyo',
					'Yokohama',
					'Kyoto',
					'Osaka',
					'Sapporo',
					'Nagoya'
				]
			}
		},
		methods: {

			/**
			* Get weather data using latitude and longitude
			*/
			getWeather: function(sLat, sLong)
			{
				$.ajax({
					url: '/api/weather/' + sLat + '/' + sLong,
					success: function(oRes, sStatus) {
						console.log(oRes)
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
						let oLatLong = oRes['context']['geo_bounds']['circle']['center'];
						console.log(oLatLong['latitude'], oLatLong['longitude']);
						self.getWeather(oLatLong['latitude'], oLatLong['longitude']);
					}
				})
			},
		}
	}
</script>