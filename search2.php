<!DOCTYPE html>
<html>
	<head>
		<title>Ride Sharing Platform - Search</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<a href="add_driver.php" class="register-button">Register as Driver</a>
	</head>
	<body>
		<h1>Ride Sharing Platform - Search</h1>
		<form action="search.php" method="get">
			<label for="destination">Destination:</label>
			<input type="text" id="destination" name="destination"><br><br>
			<label for="date">Date:</label>
			<input type="date" id="date" name="date"><br><br>
			<label for="time">Time:</label>
			<input type="time" id="time" name="time"><br><br>
			<label for="car_type">Car Type:</label>
			<select id="car_type" name="car_type">
				<option value="">Select Car Type</option>
				<option value="SUV">SUV</option>
				<option value="Sedan">Sedan</option>
				<option value="Hatchback">Hatchback</option>
			</select><br><br>
			<input type="submit" value="Search">
		</form>
		<div id="map" style="height: 400px; width: 100%;"></div>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDW9-hbczP4s9YH3Qu5UYHV5hiyiVisQeE&libraries=places"></script>
	<script>
		// Initialize Google Maps JavaScript API
		var map;

		function initMap() {
			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 15
			});

			// Try HTML5 geolocation
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					var pos = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};

					map.setCenter(pos);
				}, function() {
					handleLocationError(true, map.getCenter());
				});
			} else {
				// Browser doesn't support Geolocation
				handleLocationError(false, map.getCenter());
			}

			// Add listener to get the place details when the user clicks on the map
			google.maps.event.addListener(map, 'click', function (event) {
				var marker = new google.maps.Marker({
					position: event.latLng,
					map: map,
					draggable: true
				});

				// Reverse geocode the latitude and longitude to obtain the formatted address
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode({ 'location': event.latLng }, function (results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						document.getElementById
                        </script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDW9-hbczP4s9YH3Qu5UYHV5hiyiVisQeE&callback=initMap"></script>
	</body>
</html>