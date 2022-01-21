function thumbnailPlacing() {
    let banner = document.getElementById("user-banner");
    let tabs = document.getElementById("user-tabs");
    let footer = document.getElementById("footer");
    let navbar = document.getElementById("navbar");

    let min = window.innerHeight - navbar.offsetHeight - footer.offsetHeight;

    tabs.style.minHeight = min + "px";
    banner.minHeight = min + "px";
}

function profilePicture() {
    let pp = document.getElementById("profile-picture");
    let mpp = document.getElementById("medium-profile-picture");
    let spp = document.getElementById("small-profile-picture");
    
    pp.style.height = pp.offsetWidth + "px";
    spp.style.height = spp.offsetWidth + "px";
    mpp.style.height = mpp.offsetWidth + "px";
}

document.addEventListener("DOMContentLoaded", thumbnailPlacing);
document.addEventListener("DOMContentLoaded", profilePicture);
window.onresize = profilePicture;
