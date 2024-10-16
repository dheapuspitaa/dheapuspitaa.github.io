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
$profilePic = 'uploads/default.png'; 

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

$sqlVolunteers = "SELECT id_volunteer, volunteer_program, birthdate, file_path FROM volunteer_register WHERE username = ?";
$stmtVolunteers = $conn->prepare($sqlVolunteers);
$stmtVolunteers->bind_param("s", $username);
$stmtVolunteers->execute();
$volunteerResults = $stmtVolunteers->get_result();

if (isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $sqlDelete = "DELETE FROM volunteer_register WHERE id_volunteer = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $deleteId);
    if ($stmtDelete->execute()) {
        echo "Volunteer entry deleted successfully!";
    } else {
        echo "Error deleting volunteer entry.";
    }
    $stmtDelete->close();
    header("Location: profile.php");
    exit();
}

if (isset($_POST['update_id'])) {
    $updateId = $_POST['update_id'];
    $updatedProgram = $_POST['updated_program'];
    $updatedBirthdate = $_POST['updated_birthdate'];
    $sqlUpdate = "UPDATE volunteer_register SET volunteer_program = ?, birthdate = ? WHERE id_volunteer = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssi", $updatedProgram, $updatedBirthdate, $updateId);
    if ($stmtUpdate->execute()) {
        echo "Volunteer entry updated successfully!";
    } else {
        echo "Error updating volunteer entry.";
    }
    $stmtUpdate->close();
    header("Location: profile.php");
    exit();
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
    <link rel="stylesheet" href="profile.css" />
    <title>User Profile</title>
    <style>
        .profile-container h3 {
            margin-top: 50px;
        }

        .profile-container p {
            margin-top: 30px;
            text-align: center;
        }

        .volunteer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
        }

        .volunteer-table th, .volunteer-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .volunteer-table th {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
        }

        .volunteer-table td {
            text-align: center;
        }

        .volunteer-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .volunteer-table tr:hover {
            background-color: #ddd;
        }

        .volunteer-table input[type="text"], 
        .volunteer-table input[type="date"] {
            border: 1px solid #ddd;
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .volunteer-table button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .volunteer-table button:hover {
            background-color: var(--primary-color-dark);
        }

        .volunteer-table a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .volunteer-table a:hover {
            text-decoration: underline;
        }
    </style>
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
                <button type="button" onclick="window.location.href='dashboard.php';">Back</button>
            </div>
        </form>
        <h3>Volunteer Applications</h3>
        <table class="volunteer-table">
            <thead>
                <tr>
                    <th>Program</th>
                    <th>Birthdate</th>
                    <th>ID Card</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($volunteer = $volunteerResults->fetch_assoc()): ?>
                    <tr>
                        <td><input type="text" name="updated_program" value="<?= htmlspecialchars($volunteer['volunteer_program']); ?>" form="form_<?= $volunteer['id_volunteer']; ?>"></td>
                        <td><input type="date" name="updated_birthdate" value="<?= htmlspecialchars($volunteer['birthdate']); ?>" form="form_<?= $volunteer['id_volunteer']; ?>"></td>
                        <td><a href="<?= htmlspecialchars($volunteer['file_path']); ?>" target="_blank">View ID</a></td>
                        <td>
                            <form method="POST" id="form_<?= $volunteer['id_volunteer']; ?>">
                                <input type="hidden" name="update_id" value="<?= $volunteer['id_volunteer']; ?>">
                                <button type="submit" name="update" value="<?= $volunteer['id_volunteer']; ?>">Update</button>
                            </form><br>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                <input type="hidden" name="delete_id" value="<?= $volunteer['id_volunteer']; ?>">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>