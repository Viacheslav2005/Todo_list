const themeToggle = document.getElementById('theme-toggle');
const body = document.body;
let isDarkMode = localStorage.getItem('theme') === 'dark' ? true : false;
function toggleTheme() {
    isDarkMode = !isDarkMode;
    updateTheme();
}
function updateTheme() {
    if (isDarkMode) {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
    } else {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        localStorage.setItem('theme', 'light');
    }
}
themeToggle.addEventListener('click', toggleTheme);
// Инициализация темы при загрузке страницы
if (localStorage.getItem('theme') === null) {
    localStorage.setItem('theme', 'light');
} else {
    updateTheme();
}