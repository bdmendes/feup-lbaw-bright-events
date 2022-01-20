function thumbnailPlacing() {
    let navbar = document.getElementById("navbar");
    let thumbnail = document.getElementById("thumbnail");
    let login = document.getElementById("login-col");
    let register = document.getElementById("register-col");
    let editCol = document.getElementById("edit-col");

    if (register) {
        register.style.minHeight = window.innerHeight - navbar.offsetHeight + "px";
    }

    if (login) {
        login.style.minHeight = window.innerHeight - navbar.offsetHeight + "px";
    }

    if (editCol) {
        editCol.style.minHeight = window.innerHeight - navbar.offsetHeight + "px";
    }


    thumbnail.firstElementChild.style.height = window.innerHeight - navbar.offsetHeight + "px";
}

document.addEventListener("DOMContentLoaded", thumbnailPlacing);
