function navbarMargin() {
    let navbar = document.getElementById("navbar");
    let content = document.getElementById("content");

    content.style.paddingTop = navbar.offsetHeight + "px";
}

document.addEventListener("DOMContentLoaded", navbarMargin);
