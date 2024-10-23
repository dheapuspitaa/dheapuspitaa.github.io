<?php
require 'config.php';
session_start(); 

if (isset($_SESSION['username'])) {
    if ($_SESSION['is_admin']) {
        header("Location: admin.php");
    } else {
        header("Location: home-user.php");
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username; 
            $_SESSION['is_admin'] = ($username === 'admin'); 
            if ($_SESSION['is_admin']) {
                header("Location: admin.php");
            } else {
                header("Location: home-user.php");
            }
            exit();
        } else {
            echo "Password is wrong!";
        }
    } else {
        echo "Username not found!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/relog.css">
    <link rel="icon" href="assets/wave.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>

        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            
            <button type="submit">Login</button>

            <p class="login-register">Don't have an account?
            <a href="register.php">Register Now</a>
            </p>
        </form>
    </div>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>