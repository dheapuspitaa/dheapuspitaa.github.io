<?php
session_start(); 
include 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
         
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username']; 
            header("Location: dashboard.php"); 
            exit;
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="relog.css">
    <link rel="icon" href="assets/wave.png" />
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>

        <form method="POST">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>

            <p class="login-register">Don't have an account?
            <a href="register.php">Register Now</a>
            </p>
        </form>
    </div>
</body>
</html>
