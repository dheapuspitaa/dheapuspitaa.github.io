<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="icon" href="assets/wave.png" />
    <link rel="stylesheet" href="styles/styles.css" />
    <title>SeaHaven</title>
  </head>
  <body>
    <nav>
      <div class="nav__header" id="home">
        <div class="nav__logo">
          <a href="#home">Sea<span>Haven</span></a>
        </div>
        <div class="nav__menu__btn" id="menu-btn">
          <span><i class="ri-menu-line"></i></span>
        </div>
      </div>
      <ul class="nav__links" id="nav-links">
        <li><a href="#home">Home</a></li>
        <li><a href="#events">Events</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
      <div class="nav__btns">
        <button class="btn dark__mode__toggle" onclick="toggleDarkMode()">
          <i class="fas fa-moon"></i>
        </button>
        <button class="btn sign__up" onclick="window.location.href='register.php'">Sign Up</button>
        <button class="btn sign__in" onclick="window.location.href='login.php'">Sign In</button>
      </div>
    </nav>

    <header class="header__container">
      <div class="header__image">
        <img src="assets/whale.png" alt="header" />
      </div>
      <div class="header__content">
        <h1>PROTECT<br />THE <span>SEA</span> FOR FUTURE GENERATIONS</h1>
        <p>
          Our everyday choices is contribute to the health of the seas. <br>
          Heal our oceans and forge a path towards a brighter, bluer future.
        </p>
        <div>
          <a href="register.php" class="join-now-button">Join Now</a>
        </div>
      </div>
    </header>

    <section class="events__container" id="events">
      <h2>Our Events</h2>
      <div class="carousel">
        <div class="carousel__images">
          <img src="assets/pict_1.jpeg" alt="Event 1" class="carousel__image" />
          <img src="assets/pict_2.jpeg" alt="Event 2" class="carousel__image" />
          <img src="assets/pict_3.jpeg" alt="Event 3" class="carousel__image" />
          <img src="assets/pict_4.jpeg" alt="Event 4" class="carousel__image" />
        </div>
      </div>
    </section>    

    <section class="about__container" id="about">
      <div class="about__content">
        <h2>About</h2>
        <p>
          SeaHaven is dedicated to protecting our oceans and promoting sustainable practices.
          Join us in making a difference for the planet and future generations.
        </p>
      </div>
      <div class="about__image">
        <img src="assets/turtle.png" alt="About Image" />
      </div>
    </section>

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
    
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="main.js"></script>     
  </body>
</html>