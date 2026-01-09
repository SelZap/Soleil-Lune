// Navigation Toggle
const navbar = document.querySelector('.header .flex .navbar');
const profile = document.querySelector('.header .flex .profile');
const searchForm = document.querySelector('.header .flex .search-form');

document.querySelector('#menu-btn')?.addEventListener('click', () => {
    navbar?.classList.toggle('active');
    searchForm?.classList.remove('active');
    profile?.classList.remove('active');
});

document.querySelector('#user-btn')?.addEventListener('click', () => {
    profile?.classList.toggle('active');
    searchForm?.classList.remove('active');
    navbar?.classList.remove('active');
});

document.querySelector('#search-btn')?.addEventListener('click', () => {
    searchForm?.classList.toggle('active');
    navbar?.classList.remove('active');
    profile?.classList.remove('active');
});

window.addEventListener('scroll', () => {
    profile?.classList.remove('active');
    navbar?.classList.remove('active');
    searchForm?.classList.remove('active');
});

// Truncate content
document.querySelectorAll('.post-content').forEach(content => {
    if (content.innerHTML.length > 150) {
        content.innerHTML = content.innerHTML.slice(0, 150) + '...';
    }
});