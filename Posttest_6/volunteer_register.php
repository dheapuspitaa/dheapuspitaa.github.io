<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $username = $_SESSION['username'];
    $volunteer_name = $_POST['volunteer_name'];
    $birthdate = $_POST['birthdate'];
    $volunteer_program = $_POST['volunteer_program'];
    
    $target_dir = "volunteer_id/";
    $file_extension = pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION);
    $file_name = date('Y-m-d H.i.s') . '.' . $file_extension;
    $target_file = $target_dir . $file_name;

    $sqlUserCheck = "SELECT username FROM users WHERE username = ?";
    $stmtUserCheck = $conn->prepare($sqlUserCheck);
    $stmtUserCheck->bind_param("s", $username);
    $stmtUserCheck->execute();
    $resultUserCheck = $stmtUserCheck->get_result();

    if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO volunteer_register (username, volunteer_name, birthdate, volunteer_program, file_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $volunteer_name, $birthdate, $volunteer_program, $target_file);

        if ($stmt->execute()) {
            echo "New volunteer registered successfully!";
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }

    $conn->close();
    header("Location: volunteer_register.php"); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/wave.png" />
    <title>Volunteer Register</title>

    <style>
        :root {
            --primary-color: #152F42;
            --primary-color-dark: #306a94;
            --white: #ffffff;
        }

        body {
            font-family: "Poppins", sans-serif;
            background-color: var(--white);
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0;
            overflow: hidden;
        }

        .volunteer-container {
            color: var(--primary-color);
            max-width: 90%;
            margin: 0 auto;
            padding: 20px;
            background: var(--white);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 96%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-button {
            text-align: center; 
        }

        .form-button button {
            margin: 5px 5px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 40%;
        }

        .form-button button:hover {
            background-color: var(--primary-color-dark);
        }

        @media (max-width: 768px) {
            .volunteer-container {
                max-width: 95%; 
            }
        }
    </style>

</head>
<body>
    <div class="volunteer-container">
        <h2>Volunteer Registration Form</h2>
        <form action="volunteer_register.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="volunteer_program">Volunteer Program:</label>
                <input type="text" name="volunteer_program" required>
            </div>

            <div class="form-group">
                <label for="volunteer_name">Full Name:</label>
                <input type="text" name="volunteer_name" required>
            </div>

            <div class="form-group">
                <label for="birthdate">Birthdate:</label>
                <input type="date" name="birthdate" required>
            </div>

            <div class="form-group">
                <label for="file_upload">ID Card (Your ID Card Picture):</label>
                <input type="file" name="file_upload" required>
            </div>

            <div class="form-button">
                <button type="submit" name="submit">Submit</button>
                <button type="button" onclick="window.location.href='dashboard.php';">Back</button>
            </div>
        </form>
    </div>
</body>
</html>