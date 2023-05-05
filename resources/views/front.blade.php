<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	@vite('resources/js/app.js')
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