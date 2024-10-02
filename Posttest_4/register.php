<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="relog.css">
    <link rel="icon" href="../Posttest_4/pict/wave.png" />
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>

        <?php
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            header("Location: login.php");
            exit(); 
        } else {
        ?>

        <form action="register.php" method="POST">
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

        <?php
        }
        ?>
    </div>
</body>
</html>
