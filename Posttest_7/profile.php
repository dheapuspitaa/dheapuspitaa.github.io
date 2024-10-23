<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$username = htmlspecialchars($_SESSION['username']);
$email = ''; 
$profilePic = 'assets/default.png'; 

$sql = "SELECT email, profile_pic FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = htmlspecialchars($row['email']);
    $profilePic = !empty($row['profile_pic']) ? htmlspecialchars($row['profile_pic']) : $profilePic; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = htmlspecialchars($_POST['new_username']);
    
    if ($newUsername !== $username) {
        $sqlCheckUsername = "SELECT username FROM users WHERE username = ?";
        $stmtCheckUsername = $conn->prepare($sqlCheckUsername);
        $stmtCheckUsername->bind_param("s", $newUsername);
        $stmtCheckUsername->execute();
        $resultCheck = $stmtCheckUsername->get_result();

        if ($resultCheck->num_rows > 0) {
            echo "Username already taken. Please choose another one.";
        } else {
            $sqlUpdateUsername = "UPDATE users SET username = ? WHERE username = ?";
            $stmtUpdateUsername = $conn->prepare($sqlUpdateUsername);
            $stmtUpdateUsername->bind_param("ss", $newUsername, $username);
            $stmtUpdateUsername->execute();
            $_SESSION['username'] = $newUsername; 
            $username = $newUsername; 
        }
    }

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["profile_pic"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $fileSize = $_FILES["profile_pic"]["size"];
        
        $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
        } elseif ($fileSize > 2 * 1024 * 1024) { 
            echo "File size exceeds the maximum limit of 2MB.";
        } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png"])) { 
            echo "Only JPG, JPEG, and PNG files are allowed.";
        } else {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFile)) {
                $sqlUpdatePic = "UPDATE users SET profile_pic = ? WHERE username = ?";
                $stmtUpdatePic = $conn->prepare($sqlUpdatePic);
                $stmtUpdatePic->bind_param("ss", $targetFile, $username);
                $stmtUpdatePic->execute();
                $profilePic = $targetFile; 
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="icon" href="assets/wave.png" />
    <link rel="stylesheet" href="styles/profile.css" />
    <title>User Profile</title>
</head>
<body>
    <div class="profile-container">
        <h2>User Profile</h2>
        <img src="<?= $profilePic; ?>" alt="Profile Picture" class="profile-pic">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="new_username" value="<?= $username; ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" value="<?= $email; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Profile Picture:</label>
                <input type="file" name="profile_pic">
            </div>
            <div class="form-button">
                <button type="submit">Update Profile</button>
                <button type="button" onclick="window.location.href='home-user.php';">Back</button>
            </div>
        </form>
    </div>
</body>
</html>