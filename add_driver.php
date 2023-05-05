<!DOCTYPE html>
<html>
<head>
  <title>Ride Sharing Platform - Driver Details</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <a href="search.php" class="register-button">Register as passanger</a>s
  
</head>
<body>
  <h1>Ride Sharing Platform - Driver Details</h1>
  <form action="add_driver.php" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>
    <label for="car_type">Car Type:</label>
    <select id="car_type" name="car_type" required>
      <option value="">Select Car Type</option>
      <option value="SUV">SUV</option>
      <option value="Sedan">Sedan</option>
      <option value="Hatchback">Hatchback</option>
    </select><br><br>
    <label for="license_plate">License Plate:</label>
    <input type="text" id="license_plate" name="license_plate" required><br><br>
    
    <label for="markerCoords">Pick-up location:</label>
    <input type="text" id="markerCoords" name="markerCoords" readonly><br><br>

    <label for="destination">Destination:</label>
<div>
  <select id="destination" name="destination" onchange="checkDestination(this.value)" required>
  <option value="Athi River">Athi River</option>
<option value="Bungoma">Bungoma</option>
<option value="Busia">Busia</option>
<option value="Chuka">Chuka</option>
<option value="Embu">Embu</option>
<option value="Eldoret">Eldoret</option>
<option value="Garissa">Garissa</option>
<option value="Gilgil">Gilgil</option>
<option value="Homa Bay">Homa Bay</option>
<option value="Isiolo">Isiolo</option>
<option value="Iten">Iten</option>
<option value="Kabarnet">Kabarnet</option>
<option value="Kajiado">Kajiado</option>
<option value="Kakamega">Kakamega</option>
<option value="Kapenguria">Kapenguria</option>
<option value="Kapsabet">Kapsabet</option>
<option value="Karatina">Karatina</option>
<option value="Kericho">Kericho</option>
<option value="Keroka">Keroka</option>
<option value="Kerugoya">Kerugoya</option>
<option value="Kiambu">Kiambu</option>
<option value="Kibwezi">Kibwezi</option>
<option value="Kilifi">Kilifi</option>
<option value="Kilgoris">Kilgoris</option>
<option value="Kimilili">Kimilili</option>
<option value="Kinango">Kinango</option>
<option value="Kitale">Kitale</option>
<option value="Kitengela">Kitengela</option>
<option value="Kitui">Kitui</option>
<option value="Kwale">Kwale</option>
<option value="Lamu">Lamu</option>
<option value="Litein">Litein</option>
<option value="Lodwar">Lodwar</option>
<option value="Luanda">Luanda</option>
<option value="Machakos">Machakos</option>
<option value="Makindu">Makindu</option>
<option value="Malindi">Malindi</option>
<option value="Maralal">Maralal</option>
<option value="Marsabit">Marsabit</option>
<option value="Matuu">Matuu</option>
<option value="Meru">Meru</option>
<option value="Migori">Migori</option>
<option value="Molo">Molo</option>
<option value="Muhoroni">Muhoroni</option>
<option value="Mumias">Mumias</option>
<option value="Murang'a">Murang'a</option>
<option value="Mwea">Mwea</option>
<option value="Nairobi">Nairobi</option>
<option value="Nakuru">Nakuru</option>
<option value="Nanyuki">Nanyuki</option>
    <option value="Other">Other</option>
    <!-- Add more options here -->
  </select>
  <input type="text" id="other_destination" name="other_destination" placeholder="Other Destination" style="display:none;">
</div>

<script>
  function checkDestination(value) {
    if (value === "Other") {
      document.getElementById("other_destination").style.display = "block";
      document.getElementById("other_destination").required = true;
    } else {
      document.getElementById("other_destination").style.display = "none";
      document.getElementById("other_destination").required = false;
    }
  }
</script>

    <label for="travel_date">Date:</label>
    <input type="date" id="travel_date" name="travel_date" required><br><br>
    <label for="travel_time">Time:</label>
    <input type="time" id="travel_time" name="travel_time" required><br><br>
    
    <input type="submit" value="Submit">
  </form>
  <div id="map"></div>
</body>
</html>

<?php

// Connect to Database
$conn = new mysqli("localhost", "root", "", "ride-sharing-platform");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form has been submitted, get form data
if (isset($_POST['name'])) {
    // Get Form Data
    $name = $_POST['name'];
    $car_type = $_POST['car_type'];
    $license_plate = $_POST['license_plate'];
    $destination = $_POST['destination'];
    $travel_date = $_POST['travel_date'];
    $travel_time = $_POST['travel_time'];

    // Echo Form Data with CSS classes
    echo "<div class='driver-details'>";
    echo "<h2>Driver Details:</h2>";
    echo "<p><strong>Name:</strong> ".$name."</p>";
    echo "<p><strong>Car Type:</strong> ".$car_type."</p>";
    echo "<p><strong>License Plate:</strong> ".$license_plate."</p>";
    echo "<p><strong>Destination:</strong> ".$destination."</p>";
    echo "<p><strong>Travel Date:</strong> ".$travel_date."</p>";
    echo "<p><strong>Travel Time:</strong> ".$travel_time."</p>";
    echo "</div>";

    // Construct SQL Query
    $sql = "INSERT INTO rides (destination, date, time, car_type, driver) VALUES ('$destination', '$travel_date', '$travel_time', '$car_type', CONCAT('$name', ' (', '$license_plate', ')'))";

    // Execute SQL Query
    if($conn->query($sql) === TRUE) {
        echo "Driver details added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close Database Connection
$conn->close();
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
