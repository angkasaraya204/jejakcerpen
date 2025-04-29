// Sidebar Toggle
document.getElementById('sidebarToggle').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('sidebarOverlay').style.display = document.getElementById('sidebar').classList.contains('active') ? 'block' : 'none';
});

document.getElementById('sidebarOverlay').addEventListener('click', function() {
    document.getElementById('sidebar').classList.remove('active');
    this.style.display = 'none';
});

// Dark Mode Toggle
const darkModeToggle = document.getElementById('darkModeToggle');
const html = document.documentElement;

darkModeToggle.addEventListener('click', function() {
    this.classList.toggle('active');

    if (this.classList.contains('active')) {
        html.setAttribute('data-bs-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    } else {
        html.setAttribute('data-bs-theme', 'light');
        localStorage.setItem('theme', 'light');
    }
});

// Check for saved theme preference
const savedTheme = localStorage.getItem('theme');
if (savedTheme === 'dark') {
    darkModeToggle.classList.add('active');
    html.setAttribute('data-bs-theme', 'dark');
}

// Toggle Reply Forms
function toggleReplyForm(formId) {
    const form = document.getElementById(formId);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Show/Hide Detail View
function showDetail() {
    document.getElementById('mainContent').style.display = 'none';
    document.getElementById('detailView').style.display = 'block';
    window.scrollTo(0, 0);
}

function hideDetail() {
    document.getElementById('mainContent').style.display = 'block';
    document.getElementById('detailView').style.display = 'none';
    window.scrollTo(0, 0);
}

// Add animations to elements when scrolling
document.addEventListener('DOMContentLoaded', function() {
    const animateElements = document.querySelectorAll('.fade-in, .slide-up');

    function checkScroll() {
        animateElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;

            if (elementTop < window.innerHeight - elementVisible) {
                element.style.opacity = 1;
                element.style.transform = 'translateY(0)';
            }
        });
    }

    // Initial check
    checkScroll();

    // Check on scroll
    window.addEventListener('scroll', checkScroll);
});
