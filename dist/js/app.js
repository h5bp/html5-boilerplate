// Get the toggle button
const toggleButton = document.getElementById('dark-mode-toggle');

// Function to toggle dark mode
function toggleDarkMode() {
  document.body.classList.toggle('dark-mode');

  // Save the user's preference in localStorage
  if (document.body.classList.contains('dark-mode')) {
    localStorage.setItem('darkMode', 'enabled');
  } else {
    localStorage.removeItem('darkMode');
  }
}

// Event listener for the toggle button
toggleButton.addEventListener('click', toggleDarkMode);

// Check for saved user preference and apply it
if (localStorage.getItem('darkMode') === 'enabled') {
  document.body.classList.add('dark-mode');
}

// Check for system-wide dark mode preference
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
  document.body.classList.add('dark-mode');
}
