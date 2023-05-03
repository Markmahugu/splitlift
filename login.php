<form action="login.php" method="post">
<link rel="stylesheet" href="style.css">
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required><br><br>
  
  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required><br><br>
  
  <input type="submit" value="Login">
</form>

<?php
// Check if the form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  // Get the form data
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  // Validate the form data
  if(empty($email) || empty($password)) {
    echo 'Please fill all the fields.';
  } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Invalid email address.';
  } else {
    // Check if the user exists in the database
    // You can use any database system of your choice such as MySQL, PostgreSQL, MongoDB, etc.
    // Here is an example code using MySQL:
    
    // Connect to the database
    $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');
    
    // Check if the connection is successful
    if(!$conn) {
      die('Failed to connect to the database: ' . mysqli_connect_error());
    }
    
    // Get the user data from the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
      // User found
      $user = mysqli_fetch_assoc($result);
      
      // Verify the password
      if(password_verify($password, $user['password'])) {
        // Login successful
        echo 'Login successful.';
      } else {
        // Incorrect password
        echo 'Incorrect password.';
      }
    } else {
      // User not found
      echo 'User not found.';
    }
    
    // Close the database connection
    mysqli_close($conn);
  }
}
?>