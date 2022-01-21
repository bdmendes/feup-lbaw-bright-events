function bannerPlacing() {
    let footer = document.getElementById("footer").firstElementChild;
    let navbar = document.getElementById("navbar");
    let content = document.getElementById("event-content");
    let banner = document.getElementById("banner").firstElementChild;

    let min = window.innerHeight - navbar.offsetHeight;

    content.style.minHeight = min + "px";
    banner.style.minHeight = min + "px";
}

document.addEventListener("DOMContentLoaded", bannerPlacing, false);
window.onresize = bannerPlacing;
