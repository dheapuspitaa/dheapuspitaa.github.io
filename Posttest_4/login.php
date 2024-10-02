<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="relog.css">
    <link rel="icon" href="../Posttest_4/pict/wave.png" />
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>

        <?php
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $_SESSION['email'] = $email;

            echo "<p>Login Successful!</p>";
            if (isset($_SESSION['username'])) {
                echo "<p>Username: " . $_SESSION['username'] . "</p>";
            }
            
            echo "<p>Email $email</p>";
        } else {
        ?>

        <form action="login.php" method="POST">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>

            <p class="login-register">Don't have an account?
            <a href="register.php">Register Now</a>
            </p>
        </form>

        <?php
        }
        ?>
    </div>
</body>
</html>
