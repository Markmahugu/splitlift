<form action="register.php" method="post">
<link rel="stylesheet" href="style.css">
  <label for="name">Name:</label>
  <input type="text" id="name" name="name" required><br><br>
  
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required><br><br>
  
  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required><br><br>
  
  <label for="confirm_password">Confirm Password:</label>
  <input type="password" id="confirm_password" name="confirm_password" required><br><br>
  
  <input type="submit" value="Register">
</form>

<?php
// Check if the form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  // Get the form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  
  // Validate the form data
  if(empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    echo 'Please fill all the fields.';
  } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Invalid email address.';
  } else if($password != $confirm_password) {
    echo 'Passwords do not match.';
  } else {
    // Save the user data to the database
    // You can use any database system of your choice such as MySQL, PostgreSQL, MongoDB, etc.
    // Here is an example code using MySQL:
    
    // Connect to the database
    $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');
    
    // Check if the connection is successful
    if(!$conn) {
      die('Failed to connect to the database: ' . mysqli_connect_error());
    }
    
    // Encrypt the password
    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert the user data to the database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$encrypted_password')";
    
    if(mysqli_query($conn, $sql)) {
      // Registration successful
      echo 'Registration successful.';
    } else {
      // Registration failed
      echo 'Registration failed: ' . mysqli_error($conn);
    }
    
    // Close the database connection
    mysqli_close($conn);
  }
}
?>