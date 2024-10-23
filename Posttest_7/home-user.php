<?php
    session_start();
    include 'config.php';

    $username = $_SESSION['username'];

    $profilePic = 'assets/default.png';
    $sql = "SELECT profile_pic FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profilePic = !empty($row['profile_pic']) ? htmlspecialchars($row['profile_pic']) : $profilePic;
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="assets/wave.png" />
    <link rel="stylesheet" href="styles/home.css" />
    <title>SeaHaven</title>

  </head>
  <body>
  <header>
      <nav class="navbar">
        <div class="navbar-left">
          <span class="logo">SEAHAVEN</span>
        </div>
        <div class="navbar-right">
          <button class="search-btn"><i class="fas fa-search"></i></button>
          <div class="profile-icon" onclick="window.location.href='profile.php';">
            <img src="<?= $profilePic; ?>" alt="Profile" class="profile-pic-icon">
          </div>
          <div class="logout-btn" onclick="confirmLogout()">
              <i class="fa-solid fa-arrow-right-from-bracket"></i>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <div class="welcome-message">
        <h3>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h3>
      </div>

      <div class="tab-container">
        <div class="tab" onclick="showContent('events')">Events</div>
        <div class="tab" onclick="showContent('programs')">Volunteer Programs</div>
      </div>

      <div id="events" class="tab-content" style="display: block;">
      <div class="event-container">
        <?php
        $sql = "SELECT * FROM events";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $day = $row['day'];
                $month = $row['month'];
                $time = $row['time'];
                $location = $row['location'];
                $event_name = $row['event_name'];
                $formatted_time = date('H:i', strtotime($time));

                echo "<div class='event-date'>
                        <span class='event-day'>$day</span>
                        <span class='event-month'>$month</span>
                      </div>
                      <div class='event-time'>
                        <span>$formatted_time</span>
                        <span class='event-location'>$location</span>
                      </div>
                      <div class='event-name'>$event_name</div>";
            }
            } else {
                echo "<p>No events found.</p>";
            }
            ?>
        </div>
      </div>

      <div id="programs" class="tab-content" style="display: none;">
        <div class="volunteer-container">
        <?php
          $sql = "SELECT * FROM volunteer_programs";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $program_name = $row['program_name'];
                  $description = $row['description'];
                  $duration = $row['duration'];
                  $picture = $row['picture']; 

                  echo "
                  <div class='volunteer-card'>
                    <img src='$picture' alt='$program_name Picture'>
                    <div class='volunteer-info'>
                      <h3>$program_name</h3>
                      <p>$description</p>
                      <p>Duration : $duration</p>
                      <button class='join-btn'>Join</button>
                    </div>
                  </div>";
              }
          } else {
              echo "<p>No volunteer programs available at the moment.</p>";
          }
          ?>
        </div>
      </div>
    </main>

    <footer class="footer__container" id="contact">
      <div class="footer__content">
        <h2>Contact</h2>
        <p>Get in touch with us to learn more about our mission and how you can contribute.</p>
        <ul class="footer__contact">
          <li><a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook"></i></a></li>
          <li><a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a></li>
          <li><a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a></li>
        </ul>
      </div>
      <div class="footer__bar">
        Copyright © 2024 SeaHaven. All rights reserved.
      </div>
    </footer>

    <script>
        function showContent(id) {
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.style.display = 'none');
            document.getElementById(id).style.display = 'block';
        }

        window.onload = function() {
            showContent('events');
        };

        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php"; 
            }
        }
    </script>
  </body>
</html> 