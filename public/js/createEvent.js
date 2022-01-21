function thumbnailPlacing() {
    let navbar = document.getElementById("navbar");
    let mapWrapper = document.getElementById("map-wrapper");
    mapWrapper.style.height = window.innerHeight - navbar.offsetHeight + "px";
}

document.addEventListener("DOMContentLoaded", thumbnailPlacing);
window.onresize = thumbnailPlacing;
