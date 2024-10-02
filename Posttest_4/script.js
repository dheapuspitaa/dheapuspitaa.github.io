const toggleBtn = document.querySelector('.toggle-btn');
const toggleBtnIcon = document.querySelector('.toggle-btn i');
const dropDownMenu = document.querySelector('.dropdown-menu');

toggleBtn.onclick = function () {
    dropDownMenu.classList.toggle('open');
    const isOpen = dropDownMenu.classList.contains('open');

    toggleBtnIcon.classList = isOpen
        ? 'fa-solid fa-xmark'
        : 'fa-solid fa-bars';
}

const toggleModeBtn = document.querySelector('.mode-toggle-btn');
const body = document.body;

const currentMode = localStorage.getItem('mode');
if (currentMode === 'dark') {
    body.classList.add('dark-mode');
    toggleModeBtn.innerHTML = '<i class="fa-solid fa-sun"></i>';
} else {
    toggleModeBtn.innerHTML = '<i class="fa-solid fa-moon"></i>';
}

toggleModeBtn.onclick = function () {
    body.classList.toggle('dark-mode');

    const isDarkMode = body.classList.contains('dark-mode');
    toggleModeBtn.innerHTML = isDarkMode ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';

    if (isDarkMode) {
        localStorage.setItem('mode', 'dark');
    } else {
        localStorage.removeItem('mode');
    }
}