<?php
// Start session
session_start();

// Check if user is already logged in, redirect to dashboard if true
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.html");
    exit;
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "brainbruster";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST['name'];
    $password = $_POST['password'];

    // Query to check user credentials
    $sql = "SELECT * FROM signup WHERE name='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User exists and credentials match
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Redirect to dashboard
        header("Location: dashboard.html");
        exit;
    } else {
        // User does not exist or credentials do not match
        $error = "Invalid username or password";
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <title>LOGIN</title>
</head>
<body>
   <div class="box">
    <div class="container">
        <div class="top-header">
            <span>Have an account?</span>
            <header>LOGIN</header>
        </div><br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="input-field">
                <input type="text" class="input" placeholder="Username" name="name" required>
                <i class="bx bx-user"></i>
            </div><br>
            <div class="input-field">
                <input type="password" class="input" placeholder="Password" name="password" required>
                <i class="bx bx-lock-alt"></i>
            </div><br>
            <div class="input-field">
                <input type="submit" class="submit" value="Login">
            </div>
        </form>
        <?php if(isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        <div class="bottom">
            <div class="left">
                <input type="checkbox" id="check">
                <label for="check" style="color:black"> Remember Me</label>
            </div>
            <div class="right">
                <label><a href="#">Forgot Password</a></label>
            </div>
        </div>
    </div>
   </div>
</body>
</html>