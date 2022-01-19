function thumbnailPlacing() {
    let navbar = document.getElementById("navbar");
    let thumbnail = document.getElementById("thumbnail");
    let login = document.getElementById("login-col");

    thumbnail.firstElementChild.style.height = window.innerHeight - navbar.offsetHeight + "px";
    login.style.minHeight = window.innerHeight - navbar.offsetHeight + "px";
}

document.addEventListener("DOMContentLoaded", thumbnailPlacing);
