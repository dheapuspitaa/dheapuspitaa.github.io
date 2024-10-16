const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");
const joinNowButton = document.querySelector(".header__content a");

const carouselImages = document.querySelector('.carousel__images');
let currentIndex = 0;

function showNextImage() {
  currentIndex++;
  if (currentIndex >= carouselImages.children.length) {
    currentIndex = 0;
  }
  const offset = -currentIndex * 100; 
  carouselImages.style.transform = `translateX(${offset}%)`;
}

setInterval(showNextImage, 3000); 

menuBtn.addEventListener("click", (e) => {
  navLinks.classList.toggle("open");

  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

navLinks.addEventListener("click", (e) => {
  navLinks.classList.remove("open");
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

const scrollRevealOption = {
  distance: "50px",
  origin: "bottom",
  duration: 1000,
};

ScrollReveal().reveal(".header__image img", {
  ...scrollRevealOption,
  origin: "right",
});

ScrollReveal().reveal(".header__content h1", {
  ...scrollRevealOption,
  delay: 500,
});

ScrollReveal().reveal(".header__content p", {
  ...scrollRevealOption,
  delay: 1000,
});

window.addEventListener("load", () => {
  setTimeout(() => {
    joinNowButton.classList.remove("hidden"); 
    ScrollReveal().reveal(joinNowButton, {
      ...scrollRevealOption,
      delay: 2000,
    });
  }, 2000);
});

ScrollReveal().reveal(".header__content .bar", {
  ...scrollRevealOption,
  delay: 2500,
});

ScrollReveal().reveal(".about__image img", {
  ...scrollRevealOption,
  origin: "right",
});

ScrollReveal().reveal(".about__content h2", {
  ...scrollRevealOption,
  delay: 500,
});

ScrollReveal().reveal(".about__content p", {
  ...scrollRevealOption,
  delay: 1000,
});
