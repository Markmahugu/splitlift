<!DOCTYPE html>
<html>
<head>
  <title>Ride Sharing Platform - Driver Details</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <a href="search.php" class="register-button">Register as Driver</a>s
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACNUsBAWjrYNmt0eXAXZmvhLp90mzdVlM"></script>
  <script>
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 8
      });
      var marker = new google.maps.Marker({
        position: map.center,
        map: map
      });
    }
    window.onload = function() {
      var mapButton = document.getElementById('map-button');
      mapButton.onclick = function() {
        getLocation();
      };
    };
    function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        var geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(lat, lng);
        geocoder.geocode({'latLng': latlng}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              var address = results[0].formatted_address;
              document.getElementById('current_location').value = address;
            }
          }
        });
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: {lat: lat, lng: lng}
        });
        var marker = new google.maps.Marker({
          position: {lat: lat, lng: lng},
          map: map,
          draggable: true
        });
        google.maps.event.addListener(marker, 'dragend', function(event){
          var geocoder = new google.maps.Geocoder();
          var latlng = {lat: event.latLng.lat(), lng: event.latLng.lng()};
          geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === 'OK') {
              if (results[0]) {
                document.getElementById('current_location').value = results[0].formatted_address;
              } else {
                window.alert('No results found');
              }
            } else {
              window.alert('Geocoder failed due to: ' + status);
            }
          });
        });
      });
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  }
  </script>
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
    
    <label for="current_location">Current Location:</label>
    <input type="text" id="current_location" name="current_location" required><br><br>
    <button type="button" onclick="getLocation()" id="map-button">Select location on map</button>

    <label for="destination">Destination:</label>
    <select id="destination" name="destination" required>
      <option value="">Select Destination</option>
      <option value="Nairobi">Nairobi</option>
      <option value="Mombasa">Mombasa</option>
      <option value="Kisumu">Kisumu</option>
      <option value="Nakuru">Nakuru</option>
      <option value="Eldoret">Eldoret</option>
      <option value="Thika">Thika</option>
      <option value="Malindi">Malindi</option>
      <option value="Kitale">Kitale</option>
      <option value="Machakos">Machakos</option>
      <option value="Garissa">Garissa</option>
      <option value="Kakamega">Kakamega</option>
      <option value="Nyeri">Nyeri</option>
      <option value="Meru">Meru</option>
      <option value="Kericho">Kericho</option>
      <option value="Embu">Embu</option>
      <option value="Isiolo">Isiolo</option>
      <option value="Lamu">Lamu</option>
      <option value="Mandera">Mandera</option>
      <option value="Bungoma">Bungoma</option>
      <option value="Busia">Busia</option>
      <option value="Voi">Voi</option>
      <option value="Homa Bay">Homa Bay</option>
      <option value="Migori">Migori</option>
      <option value="Kiambu">Kiambu</option>
      <option value="Kilifi">Kilifi</option>
      <option value="Taveta">Taveta</option>
      <option value="Narok">Narok</option>
      <option value="Kwale">Kwale</option>
      <option value="Kajiado">Kajiado</option>
      <option value="Marsabit">Marsabit</option>
    </select><br><br>
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