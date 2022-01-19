function thumbnailPlacing() {
    let navbar = document.getElementById("navbar");
    let footer = document.getElementById("footer");
    let thumbnail = document.getElementById("thumbnail");

    thumbnail.firstElementChild.style.height = window.innerHeight - navbar.offsetHeight + "px";
}

document.addEventListener("DOMContentLoaded", thumbnailPlacing);
