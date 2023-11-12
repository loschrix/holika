//Slideshow start
let sIndex = 1;
let timeout_s;
let isHovering = false;
let slides = document.querySelectorAll(".slide");

showSlides(sIndex);

const plusSlides = (n) => {
    showSlides(sIndex += n);
    pauseAutoSlideshow();
}

const currentSlide = (n) => {
    showSlides(sIndex = n);
    pauseAutoSlideshow();
}

function showSlides(n) {
    let dots = document.querySelectorAll(".dot");
    sIndex = (n > slides.length) ? 1 : (n < 1) ? slides.length : n;
    slides.forEach(slide => slide.style.display = "none");
    dots.forEach(dot => dot.classList.replace('fa-solid', 'fa-regular'));
    slides[sIndex - 1].style.display = "block";
    dots[sIndex - 1].classList.replace('fa-regular', 'fa-solid');
    resetTimeout();
}

function startAutoSlideshow() {
    if (!isHovering) {
        timeout_s = setTimeout(() => {
            plusSlides(1);
            startAutoSlideshow();
        }, 3000);
    }
}

function resetTimeout() {
    clearTimeout(timeout_s);
    startAutoSlideshow();
}

function pauseAutoSlideshow() {
    clearTimeout(timeout_s);
}

document.addEventListener('mousemove', resetTimeout);
document.addEventListener('keydown', resetTimeout);

slides.forEach(slide => {
    slide.addEventListener('mouseover', () => {
        isHovering = true;
    });

    slide.addEventListener('mouseout', () => {
        isHovering = false;
        startAutoSlideshow();
    });
});
//Slideshow end