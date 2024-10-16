<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "Username or Email already exists. Please use a different one.";
    } else {

        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
        
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="relog.css">
    <link rel="icon" href="assets/wave.png" />
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>

        <form method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Register</button>

            <p class="login-register">Have an account?
            <a href="login.php">Login</a>
            </p>
        </form>
    </div>
</body>
</html>
