function thumbnailPlacing() {
    let banner = document.getElementById("user-banner");
    let tabs = document.getElementById("user-tabs");
    let footer = document.getElementById("footer");
    let navbar = document.getElementById("navbar");

    let min = window.innerHeight - navbar.offsetHeight - footer.offsetHeight;

    tabs.style.minHeight = min + "px";
    banner.minHeight = min + "px";
}

document.addEventListener("DOMContentLoaded", thumbnailPlacing);
