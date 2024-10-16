<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']); 

$profilePic = 'uploads/default.png';
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
    <link rel="stylesheet" href="dashboard.css" />
    <title>SeaHaven</title>

    <style>
        .welcome-message {
            text-align: center;
            margin: 20px 0; 
            font-size: 1.5rem; 
            font-family: "Poppins", sans-serif;
            color: #3b3933;  
        }

        .profile-pic-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
        }

        .logout-btn i {
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>

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
          <div class="logout-btn" onclick="window.location.href='logout.php';">
              <i class="fa-solid fa-arrow-right-from-bracket"></i>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <div class="welcome-message">
        <h3>Welcome back,<br> <?= $username; ?>!</h3>
      </div>

      <div class="tab-container">
        <div class="tab" onclick="showContent('events')">Events</div>
        <div class="tab" onclick="showContent('donate')">Donate</div>
        <div class="tab" onclick="showContent('volunteers')">Volunteers</div>
      </div>

      <div id="events" class="tab-content" style="display: block;">
        <div class="event-container">
          <div class="event-date">
            <span class="event-day">10</span>
            <span class="event-month">Oct</span>
          </div>
          <div class="event-time">
            <span>10:00 AM</span>
            <span class="event-location">Sunny Beach</span>
          </div>
          <div class="event-name">Beach Clean-up</div>
        </div>
        
        <div class="event-container">
          <div class="event-date">
            <span class="event-day">12</span>
            <span class="event-month">Oct</span>
          </div>
          <div class="event-time">
            <span>1:00 PM</span>
            <span class="event-location">Coral Bay</span>
          </div>
          <div class="event-name">Coral Restoration Project</div>
        </div>
        
        <div class="event-container">
          <div class="event-date">
            <span class="event-day">15</span>
            <span class="event-month">Oct</span>
          </div>
          <div class="event-time">
            <span>2:00 PM</span>
            <span class="event-location">Marine Center</span>
          </div>
          <div class="event-name">Marine Conservation Workshop</div>
        </div>

        <div class="event-container">
          <div class="event-date">
            <span class="event-day">18</span>
            <span class="event-month">Oct</span>
          </div>
          <div class="event-time">
            <span>4:00 PM</span>
            <span class="event-location">Marine Center</span>
          </div>
          <div class="event-name">Underwater Photography Class</div>
        </div>

        <div class="event-container">
          <div class="event-date">
            <span class="event-day">20</span>
            <span class="event-month">Oct</span>
          </div>
          <div class="event-time">
            <span>6:00 PM</span>
            <span class="event-location">Pebble Beach</span>
          </div>
          <div class="event-name">Evening Eco-Talk</div>
        </div>

        <div class="event-container">
          <div class="event-date">
            <span class="event-day">22</span>
            <span class="event-month">Oct</span>
          </div>
          <div class="event-time">
            <span>9:00 AM</span>
            <span class="event-location">City Park</span>
          </div>
          <div class="event-name">Volunteer Meetup</div>
        </div>

        <div class="event-container">
          <div class="event-date">
            <span class="event-day">25</span>
            <span class="event-month">Oct</span>
          </div>
          <div class="event-time">
            <span>11:00 AM</span>
            <span class="event-location">Sunny Beach</span>
          </div>
          <div class="event-name">Shoreline Restoration</div>
        </div>

        <div class="event-container">
          <div class="event-date">
            <span class="event-day">28</span>
            <span class="event-month">Oct</span>
          </div>
          <div class="event-time">
            <span>3:00 PM</span>
            <span class="event-location">Coral Bay</span>
          </div>
          <div class="event-name">Community Picnic</div>
        </div>
      </div>

      <div id="donate" class="tab-content" style="display: none;">
          <div class="donation-container">
              <div class="donation-card">
                  <img src="assets/don1.jpeg" alt="GreenFund : Sustain Earth Now">
                  <div class="donation-info">
                      <h3>GreenFund : Sustain Earth Now</h3>
                      <p>$50,240,210</p>
                      <div class="progress-bar">
                          <div class="progress" style="width: 90%;"></div>
                      </div>
                      <p class="days-left">7 days left</p>
                  </div>
              </div>

              <div class="donation-card">
                  <img src="assets/don2.jpeg" alt="SeniorHealth : Support Campaign">
                  <div class="donation-info">
                      <h3>SeniorHealth : Support Campaign</h3>
                      <p>$4,240,310</p>
                      <div class="progress-bar">
                          <div class="progress" style="width: 60%;"></div>
                      </div>
                      <p class="days-left">19 days left</p>
                  </div>
              </div>

              <div class="donation-card">
                  <img src="assets/don3.jpeg" alt="DisasterCare : Urgent Support">
                  <div class="donation-info">
                      <h3>DisasterCare : Urgent Support</h3>
                      <p>$2,100,210</p>
                      <div class="progress-bar">
                          <div class="progress" style="width: 40%;"></div>
                      </div>
                      <p class="days-left">23 days left</p>
                  </div>
              </div>

              <div class="donation-card">
                  <img src="assets/don4.jpeg" alt="OceanCleanup : Save Our Seas">
                  <div class="donation-info">
                      <h3>OceanCleanup : Save Our Seas</h3>
                      <p>$10,500,700</p>
                      <div class="progress-bar">
                          <div class="progress" style="width: 75%;"></div>
                      </div>
                      <p class="days-left">10 days left</p>
                  </div>
              </div>

              <div class="donation-card">
                  <img src="assets/don5.jpeg" alt="ForestFund : Protect Wildlife">
                  <div class="donation-info">
                      <h3>ForestFund : Protect Wildlife</h3>
                      <p>$3,780,900</p>
                      <div class="progress-bar">
                          <div class="progress" style="width: 50%;"></div>
                      </div>
                      <p class="days-left">15 days left</p>
                  </div>
              </div>

              <div class="donation-card">
                  <img src="assets/don6.jpeg" alt="ReefRescue : Coral Revival">
                  <div class="donation-info">
                      <h3>ReefRescue : Coral Revival</h3>
                      <p>$6,400,210</p>
                      <div class="progress-bar">
                          <div class="progress" style="width: 80%;"></div>
                      </div>
                      <p class="days-left">12 days left</p>
                  </div>
              </div>

              <div class="donation-card">
                  <img src="assets/don7.jpeg" alt="ClimateAction : Green Initiatives">
                  <div class="donation-info">
                      <h3>ClimateAction : Green Initiatives</h3>
                      <p>$12,100,150</p>
                      <div class="progress-bar">
                          <div class="progress" style="width: 65%;"></div>
                      </div>
                      <p class="days-left">9 days left</p>
                  </div>
              </div>

              <div class="donation-card">
                  <img src="assets/don8.jpeg" alt="WaterRelief : Fresh Water Access">
                  <div class="donation-info">
                      <h3>WaterRelief : Fresh Water Access</h3>
                      <p>$5,340,600</p>
                      <div class="progress-bar">
                          <div class="progress" style="width: 55%;"></div>
                      </div>
                      <p class="days-left">16 days left</p>
                  </div>
              </div>

              <div class="donation-card">
                  <img src="assets/don9.jpeg" alt="SolarEnergy : Clean Energy Future">
                  <div class="donation-info">
                      <h3>SolarEnergy : Clean Energy Future</h3>
                      <p>$8,760,450</p>
                      <div class="progress-bar">
                          <div class="progress" style="width: 70%;"></div>
                      </div>
                      <p class="days-left">5 days left</p>
                  </div>
              </div>
          </div>
      </div>

      <div id="volunteers" class="tab-content" style="display: none;">
        <div class="volunteer-container">
            <div class="volunteer-card">
                <img src="assets/vol1.jpeg" alt="Beach Cleanup Volunteer Program">
                <div class="volunteer-info">
                    <h3>Beach Cleanup Volunteer Program</h3>
                    <p>Duration : 3 months</p>
                    <button class="join-btn" onclick="window.location.href='volunteer_register.php';">Join</button>
                </div>
            </div>

            <div class="volunteer-card">
                <img src="assets/vol2.jpeg" alt="Coral Reef Protection Program">
                <div class="volunteer-info">
                    <h3>Coral Reef Protection Program</h3>
                    <p>Duration : 6 months</p>
                    <button class="join-btn" onclick="window.location.href='volunteer_register.php';">Join</button>
                </div>
            </div>

            <div class="volunteer-card">
                <img src="assets/vol3.jpeg" alt="Marine Wildlife Conservation">
                <div class="volunteer-info">
                    <h3>Marine Wildlife Conservation</h3>
                    <p>Duration : 1 year</p>
                    <button class="join-btn" onclick="window.location.href='volunteer_register.php';">Join</button>
                </div>
            </div>

            <div class="volunteer-card">
                <img src="assets/vol4.jpeg" alt="Forest Regrowth Initiative">
                <div class="volunteer-info">
                    <h3>Forest Regrowth Initiative</h3>
                    <p>Duration : 4 months</p>
                    <button class="join-btn" onclick="window.location.href='volunteer_register.php';">Join</button>
                </div>
            </div>

            <div class="volunteer-card">
                <img src="assets/vol5.jpeg" alt="Water Purification Project">
                <div class="volunteer-info">
                    <h3>Water Purification Project</h3>
                    <p>Duration : 2 months</p>
                    <button class="join-btn" onclick="window.location.href='volunteer_register.php';">Join</button>
                </div>
            </div>
        </div>
    </div>
    </main>
    <script src="script.js"></script>
  </body>
</html> 