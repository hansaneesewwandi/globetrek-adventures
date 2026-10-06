// Mobile navigation
const menuBtn = document.querySelector('.menu-btn');
const navLinks = document.querySelector('.nav-links');

if (menuBtn && navLinks) {
    menuBtn.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        menuBtn.textContent = navLinks.classList.contains('active') ? '×' : '☰';
    });
}

// Home video slider
const heroDots = document.querySelectorAll('.hero-dot');
const videoSlides = document.querySelectorAll('.video-slide');
const heroContents = document.querySelectorAll('.hero-content');

function heroSlider(index) {
    heroDots.forEach(dot => dot.classList.remove('active'));
    videoSlides.forEach(slide => slide.classList.remove('active'));
    heroContents.forEach(content => content.classList.remove('active'));

    if (heroDots[index]) heroDots[index].classList.add('active');
    if (videoSlides[index]) videoSlides[index].classList.add('active');
    if (heroContents[index]) heroContents[index].classList.add('active');
}

heroDots.forEach((dot, index) => {
    dot.addEventListener('click', () => heroSlider(index));
});

// Package page 3D image slider
const nextBtn = document.querySelector('.pkg-next');
const prevBtn = document.querySelector('.pkg-prev');
const packageSlide = document.querySelector('.package-slide');

if (nextBtn && packageSlide) {
    nextBtn.addEventListener('click', () => {
        const items = document.querySelectorAll('.slider-item');
        if (items.length > 0) packageSlide.appendChild(items[0]);
    });
}

if (prevBtn && packageSlide) {
    prevBtn.addEventListener('click', () => {
        const items = document.querySelectorAll('.slider-item');
        if (items.length > 0) packageSlide.prepend(items[items.length - 1]);
    });
}

// Basic client-side validation for booking form
const bookingForm = document.querySelector('#bookingForm');
if (bookingForm) {
    bookingForm.addEventListener('submit', function (event) {
        const travellers = document.querySelector('#travellers');
        if (travellers && Number(travellers.value) < 1) {
            event.preventDefault();
            alert('Number of travellers must be at least 1.');
        }
    });
}
