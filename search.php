<!DOCTYPE html>
<html>
<head>
    <title>Ride Sharing Platform - Search</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    <label for="markerCoords">Marker Coordinates:</label>
    <input type="text" id="markerCoords" name="markerCoords" readonly><br><br>
    <input type="submit" value="Search">
</form>

    <a href="add_driver.php" class="register-button">Register as Driver</a>

	<?php
// Connect to Database
$conn = new mysqli("localhost", "root", "", "ride-sharing-platform") or die("unable to connect");

// Check if form has been submitted
if (isset($_GET['destination'])) {
  // Get Form Data
  $destination = isset($_GET['destination']) ? mysqli_real_escape_string($conn, $_GET['destination']) : '';
  $date = isset($_GET['date']) ? mysqli_real_escape_string($conn, $_GET['date']) : '';
  $time = isset($_GET['time']) ? mysqli_real_escape_string($conn, $_GET['time']) : '';
  $car_type = isset($_GET['car_type']) ? mysqli_real_escape_string($conn, $_GET['car_type']) : '';

// Construct SQL Query
$sql = "SELECT * FROM rides WHERE destination LIKE '%$destination%' AND date = '$date'";

  if(!empty($time)) {
    $time_start = date('H:i:s', strtotime($time) - 10800); // 3 hours before desired time
    $time_end = date('H:i:s', strtotime($time) + 10800); // 3 hours after desired time

    $sql .= " AND time BETWEEN '$time_start' AND '$time_end'";
  }

  if($car_type != "") {
    $sql .= " AND car_type = '$car_type'";
  }

  // Execute SQL Query
  $result = mysqli_query($conn, $sql);

  // Display Search Results
  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo '<div class="result">';
      echo '<h2>Ride Details</h2>';
      echo '<p><span>Destination:</span> '.$row['destination'].'</p>';
      echo '<p><span>Date:</span> '.$row['date'].'</p>';
      echo '<p><span>Time:</span> '.$row['time'].'</p>';
      echo '<p><span>Car Type:</span> '.$row['car_type'].'</p>';
      echo '<p><span>Driver:</span> '.$row['driver'].'</p>';
      echo '<a href="#">Request Ride</a>';
      echo '</div>';
    }
  } else {
    echo '<p>No rides found. Please try again.</p>';
  }
}

// Close Database Connection
mysqli_close($conn);
?>


<div id="map" style="height: 400px; width: 100%;"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDW9-hbczP4s9YH3Qu5UYHV5hiyiVisQeE&libraries=places"></script>
<script>
    // Initialize Google Maps Places API
    var autocomplete = new google.maps.places.Autocomplete(document.getElementById('destination'));
    // Set the types of autocomplete suggestions
    autocomplete.setTypes(['geocode']);
    // Add listener to update the input value with the selected location
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        document.getElementById('destination').value = place.formatted_address;
        document.getElementById('markerCoords').value = place.geometry.location.lat().toFixed(6) + ", " + place.geometry.location.lng().toFixed(6) + " (" + place.name + ")";
    });
    // Initialize Google Maps JavaScript API
    var map;
    var marker;
    function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15
    });
    // Try HTML5 geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            map.setCenter(pos);
            marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: "You are here!",
                draggable: true
            });
            var currentLocation = document.createElement('p');
            currentLocation.innerHTML = "Current Location: " + pos.lat.toFixed(6) + ", " + pos.lng.toFixed(6) + " (Your location)";
            document.getElementById('map').appendChild(currentLocation);
            // Add listener to update marker coordinates on marker drag
            google.maps.event.addListener(marker, 'dragend', function() {
                var markerCoords = document.getElementById('markerCoords');
                var latLng = marker.getPosition();
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'location': latLng}, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            markerCoords.value = latLng.lat().toFixed(6) + ", " + latLng.lng().toFixed(6) + " (" + results[0].formatted_address + ")";
                        } else {
                            markerCoords.value = latLng.lat().toFixed(6) + ", " + latLng.lng().toFixed(6);
                        }
                    } else {
                        markerCoords.value = latLng.lat().toFixed(6) + ", " + latLng.lng().toFixed(6);
                    }
                });
            });
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

    function handleLocationError(browserHasGeolocation, pos) {
        var infoWindow = new google.maps.InfoWindow({ map: map });
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                               'Error: The Geolocation service failed.' :
                               'Error: Your browser doesn\'t support geolocation.');
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDW9-hbczP4s9YH3Qu5UYHV5hiyiVisQeE&callback=initMap"></script>

</body>
</html> 
