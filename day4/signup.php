<!DOCTYPE html>
<?php
  // Include server.php for database connection and other server-side operations
  include('connect.php');
  
  // Function to check if a user already exists in the database
  function userExists($conn, $email) {
      $sql = "SELECT * FROM signup WHERE email='$email'";
      $result = $conn->query($sql);
      return $result->num_rows > 0;
  }
  
  // Function to get the number of registered users
  function getNumberOfUsers($conn) {
      $sql = "SELECT COUNT(*) as total FROM signup";
      $result = $conn->query($sql);
      $data = $result->fetch_assoc();
      return $data['total'];
  }
  
  // Check if form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Retrieve form data
      $name = $_POST['name'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $password = $_POST['password'];
      
      // Check if all fields are filled
      if (empty($name) || empty($email) || empty($phone) || empty($password)) {
          echo "All fields are required!";
      } else {
          // Check if user already exists
          if (userExists($conn, $email)) {
              echo "User already exists!";
          } else {
              // Prepare SQL statement to insert data into the database
              $sql = "INSERT INTO signup (name, email, phone,password) VALUES ('$name', '$email', '$phone','$password')";
  
              if ($conn->query($sql) === TRUE) {
                echo "User registered successfully";
                header("Location: login.php");
                exit(); // Make sure to exit after the header redirect
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
          }
      }
      
      echo "Total registered users: " . getNumberOfUsers($conn);
  }

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <title>SignUp</title>
</head>
<body>
   <div class="box">
   <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="container">
        <div class="top-header">
            <span>Have an account?</span>
            <header>SIGNUP</header>
        </div><br>
        <div class="input-field">
            <input type="text" name="name" class="input" placeholder="Name" required>
            <i class="bx bx-user"></i>
        </div><br>
        
        <div class="input-field">
            <input type="text" name="email" class="input" placeholder="email" required>
            <i class="bx bx-user"></i>
        </div><br>
        <div class="input-field">
            <input type="number" name="phone" class="input" placeholder="Phone number" required>
            <i class="bx bx-user"></i>
        </div><br>
        <div class="input-field">
            <input type="password" name="password" class="input" placeholder="Password" required>
            <i class="bx bx-lock-alt"></i>
        </div><br>
        <a href="login.php">
        <div class="input-field">
            <input type="submit" class="submit" value = "REGISTER">
        </div>
        </a>
        </div>
    </div>
</form>
   </div>
</body>
</html>