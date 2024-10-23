<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['username']) || !$_SESSION['is_admin']) {
    header("Location: home-user.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['event_name'])) {

        $event_name = $conn->real_escape_string($_POST['event_name']);
        $day = (int)$_POST['day'];
        $month = $conn->real_escape_string($_POST['month']);
        $time = $conn->real_escape_string($_POST['time']);
        $location = $conn->real_escape_string($_POST['location']);
        
        if (isset($_POST['event_id']) && $_POST['event_id'] != '') {
            $event_id = (int)$_POST['event_id'];
            $update_sql = "UPDATE events SET event_name='$event_name', day=$day, month='$month', time='$time', location='$location' WHERE id=$event_id";
            if ($conn->query($update_sql) === TRUE) {
                header("Location: admin.php");
                exit();
            } else {
                echo "Error updating event: " . $conn->error;
            }
        } else {
            $sql = "INSERT INTO events (event_name, day, month, time, location) VALUES ('$event_name', $day, '$month', '$time', '$location')";
            if ($conn->query($sql) === TRUE) {
                header("Location: admin.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    if (isset($_POST['program_name'])) {
        $program_name = $conn->real_escape_string($_POST['program_name']);
        $description = $conn->real_escape_string($_POST['description']);
        $duration = $conn->real_escape_string($_POST['duration']);
        $picture = ''; 

        if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_type = mime_content_type($_FILES['picture']['tmp_name']);
            if (in_array($file_type, $allowed_types)) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["picture"]["name"]);
                move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);
                $picture = $target_file;
            } else {
                echo "Invalid file type. Please upload a valid image.";
            }
        }        

        if (isset($_POST['program_id']) && $_POST['program_id'] != '') {
            $program_id = (int)$_POST['program_id'];
            $update_sql = "UPDATE volunteer_programs SET program_name='$program_name', description='$description', duration='$duration', picture='$picture' WHERE id=$program_id";
            if ($conn->query($update_sql) === TRUE) {
                header("Location: admin.php");
                exit();
            } else {
                echo "Error updating volunteer program: " . $conn->error;
            }
        } else {
            $sql = "INSERT INTO volunteer_programs (program_name, description, duration, picture) VALUES ('$program_name', '$description', '$duration', '$picture')";
            if ($conn->query($sql) === TRUE) {
                header("Location: admin.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $event_id = (int)$_GET['delete'];
    $delete_sql = "DELETE FROM events WHERE id = $event_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "Event deleted successfully.";
    } else {
        echo "Error deleting event: " . $conn->error;
    }
}

$event_name = '';
$day = '';
$month = '';
$time = '';
$location = '';
$isEditing = false;

if (isset($_GET['edit'])) {
    $isEditing = true;
    $event_id = (int)$_GET['edit'];
    $sql = "SELECT * FROM events WHERE id = $event_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        $event_name = $event['event_name'];
        $day = $event['day'];
        $month = $event['month'];
        $time = $event['time'];
        $location = $event['location'];
    }
}

if (isset($_GET['delete_program'])) {
    $program_id = (int)$_GET['delete_program'];
    $delete_sql = "DELETE FROM volunteer_programs WHERE id = $program_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "Volunteer program deleted successfully.";
    } else {
        echo "Error deleting volunteer program: " . $conn->error;
    }
}

$program_name = '';
$description = '';
$duration = '';
$picture = '';
$isEditingProgram = false;

if (isset($_GET['edit_program'])) {
    $isEditingProgram = true;
    $program_id = (int)$_GET['edit_program'];
    $sql = "SELECT * FROM volunteer_programs WHERE id = $program_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $program = $result->fetch_assoc();
        $program_name = $program['program_name'];
        $description = $program['description'];
        $duration = $program['duration'];
        $picture = $program['picture'];
    }
}


$search_event = isset($_GET['search-event']) ? $conn->real_escape_string($_GET['search-event']) : '';
if ($search_event) {
    $events_sql = "SELECT * FROM events WHERE event_name LIKE '$search_event%'";
} else {
    $events_sql = "SELECT * FROM events"; 
}
$events_result = $conn->query($events_sql);


$search_program = isset($_GET['search-program']) ? $conn->real_escape_string($_GET['search-program']) : '';
if ($search_program) {
    $programs_sql = "SELECT * FROM volunteer_programs WHERE program_name LIKE '$search_program%'";
} else {
    $programs_sql = "SELECT * FROM volunteer_programs"; 
}
$programs_result = $conn->query($programs_sql);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/wave.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/admin.css" />
    <title>Dashboard</title>
</head>
<body>
    <div class="sidebar">
        <h2>SeaHaven</h2>
        <a href="#events" onclick="showSection('events-section')">Events</a>
        <a href="#program" onclick="showSection('program-section')">Volunteer Programs</a>
        <a href="#" onclick="confirmLogout()">Logout</a>
    </div>

    <div id="events-section" class="main-content active">
        <div class="event-form">
            <h2><?= $isEditing ? 'Update Event' : 'Create or Update Events' ?></h2>
            <form action="admin.php" method="POST">
                <input type="hidden" name="event_id" value="<?= $isEditing ? $event_id : '' ?>">
                <label for="event-name">Event Name :</label>
                <input type="text" id="event-name" name="event_name" value="<?= $event_name ?>" required>

                <label for="day">Day :</label>
                <input type="number" id="day" name="day" min="1" max="31" value="<?= $day ?>" required>

                <label for="month">Month :</label>
                <select id="month" name="month" required>
                    <?php
                    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    foreach ($months as $m) {
                        $selected = ($month == $m) ? "selected" : "";
                        echo "<option value='$m' $selected>$m</option>";
                    }
                    ?>
                </select>

                <label for="time">Time :</label>
                <input type="time" id="time" name="time" value="<?= $time ?>" required>

                <label for="location">Location :</label>
                <input type="text" id="location" name="location" value="<?= $location ?>" required>
                
                <button type="submit"><?= $isEditing ? 'Update Event' : 'Create Event' ?></button>
            </form>
        </div>

        <form action="" method="GET" class="search-bar-event">
            <input type="text" name="search-event" placeholder="Search by event name"
            class="search-input-event" />
            <button type="submit" class="search-button-event">
            <i class="fa-solid fa-magnifying-glass fa-xl"></i>
            </button>
        </form>

        <div class="event-table-container">
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Day</th>
                        <th>Month</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT * FROM events";
                    $result = $conn->query($sql);

                    if ($events_result->num_rows > 0) {
                        while ($row = $events_result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['event_name']}</td>
                                    <td>{$row['day']}</td>
                                    <td>{$row['month']}</td>
                                    <td>{$row['time']}</td>
                                    <td>{$row['location']}</td>
                                    <td>
                                        <form action='admin.php' method='GET' style='display:inline;'>
                                            <input type='hidden' name='delete' value='{$row['id']}'>
                                            <button type='submit' onclick='return confirm(\"Are you sure you want to delete this event?\");'>Delete</button>
                                        </form>
                                        <form action='admin.php' method='GET' style='display:inline;'>
                                            <input type='hidden' name='edit' value='{$row['id']}'>
                                            <button type='submit'>Edit</button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No events found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="program-section" class="main-content">
        <div class="program-form">
            <h2><?= $isEditingProgram ? 'Update Volunteer Program' : 'Create Volunteer Program' ?></h2>
            <form action="admin.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="program_id" value="<?= $isEditingProgram ? $program_id : '' ?>">
                
                <label for="program-name">Program Name :</label>
                <input type="text" id="program-name" name="program_name" value="<?= $program_name ?>" required>

                <label for="description">Description :</label>
                <textarea id="description" name="description" required><?= $description ?></textarea>

                <label for="duration">Duration :</label>
                <input type="text" id="duration" name="duration" value="<?= $duration ?>" placeholder="Ex : 1 Month / 1 Year" required>

                <label for="picture">Picture :</label>
                <input type="file" id="picture" name="picture" accept="image/*">

                <button type="submit"><?= $isEditingProgram ? 'Update Program' : 'Create Program' ?></button>
            </form>
        </div>

        <form action="" method="GET" class="search-bar-program">
            <input type="text" name="search-program" placeholder="Search by program name"
            class="search-input-program" />
            <button type="submit" class="search-button-program">
            <i class="fa-solid fa-magnifying-glass fa-xl"></i>
            </button>
        </form>

        <div class="program-table-container">
            <table>
                <thead>
                    <tr>
                        <th>Program Name</th>
                        <th>Description</th>
                        <th>Duration</th>
                        <th>Picture</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
    
                    $sql = "SELECT * FROM volunteer_programs";
                    $result = $conn->query($sql);

                    if ($programs_result->num_rows > 0) {
                        while ($row = $programs_result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['program_name']}</td>
                                    <td>{$row['description']}</td>
                                    <td>{$row['duration']}</td>
                                    <td><img src='{$row['picture']}' alt='Program Picture' style='width: 100px;'></td>
                                    <td>
                                        <form action='admin.php' method='GET' style='display:inline;'>
                                            <input type='hidden' name='delete_program' value='{$row['id']}'>
                                            <button type='submit' onclick='return confirm(\"Are you sure you want to delete this program?\");'>Delete</button>
                                        </form>
                                        <form action='admin.php' method='GET' style='display:inline;'>
                                            <input type='hidden' name='edit_program' value='{$row['id']}'>
                                            <button type='submit'>Edit</button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No volunteer programs found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php"; 
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?> 