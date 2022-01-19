function pullContentUp() {
    let content = document.getElementById("content");

    content.style.paddingTop = "0";
}

function navbarTransition() {
    let windowHeight = window.innerHeight;
    let navbar = document.getElementById("navbar");

    let visibilityBorder = document.getElementById("trends").getBoundingClientRect().top;

    let view = windowHeight - navbar.offsetHeight;
    let distance = visibilityBorder - navbar.offsetHeight;

    let percentage = (view - distance) / view;

    if (percentage < 0) {
        percentage = 0;
    }
    
    if (percentage > 1) {
        percentage = 1;
    }

    console.log("rgba(247, 255, 247, " + (0.3 + percentage * 0.7) + ") !important");

    navbar.style.backgroundColor = "rgba(247, 255, 247, " + (0.3 + percentage * 0.7) + ")";
    //background-color: rgba(247, 255, 247, 0.3) !important;

    //box-shadow: 0 0 10px 2px rgba(247, 255, 247, 0.3);
}

function startCarousel() {
    let eventsCarousel = document.getElementById("events-carousel-inner");

    eventsCarousel.firstElementChild.classList.add("active");
}

document.addEventListener("DOMContentLoaded", pullContentUp);
document.addEventListener("scroll", navbarTransition);
document.addEventListener("DOMContentLoaded", startCarousel);
