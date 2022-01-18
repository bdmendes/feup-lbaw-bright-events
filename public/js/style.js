function navbarMargin() {
    let navbar = document.getElementById("navbar");
    let main = document.getElementById("main");
    
    main.style.marginTop = navbar.offsetHeight + "px";
}

document.addEventListener("DOMContentLoaded", navbarMargin);
