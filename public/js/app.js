/**
 * Reads from an input that has a datalist, and adds one span and hidden input to div
 * @param {*} div -> Div to add the new span elem
 * @param {*} inputId -> Div to read the input from
 * @param {*} arrayId  -> Array id, to add to the hidden input's name field
 */
function addTag(selection, tagsDiv) {
    let selec = document.getElementById(selection);
    let checkbox = document.getElementById(
        document.getElementById(selec.value).dataset.id
    );
    let div = document.getElementById(tagsDiv);

    if (checkbox.checked !== true) {
        let node = document.getElementById("tagEx").cloneNode();
        node.classList.remove("d-none");
        node.textContent = selec.value;
        div.append(node);
        checkbox.checked = true;
    }

    document.getElementById(selection).value = "";
}

function removeTag(tag) {
    let checkbox = document.getElementById(
        document.getElementById(tag.textContent.replace(/\s+/g, "")).dataset.id
    );
    checkbox.checked = false;
    tag.remove();
}

function createSmallCard(username, profile_picture, name) {
    let entry = document.createElement("div");
    let div = document.createElement("div");

    entry.appendChild(div);
    let first_child = document.createElement("div");
    let first_child_div = document.createElement("div");
    let img = document.createElement("img");

    first_child_div.appendChild(img);
    first_child.appendChild(first_child_div);
    div.appendChild(first_child);

    let second_child = document.createElement("div");
    let second_child_div = document.createElement("div");
    let small = document.createElement("small");

    second_child.appendChild(second_child_div);
    second_child.appendChild(small);
    div.appendChild(second_child);

    entry.id = username + "-entry";
    entry.classList.add("border", "rounded", "d-flex", "p-1");
    entry.style.width = "250px";
    div.classList.add(
        "d-flex",
        "justify-content-start",
        "align-items-center",
        "gap-4"
    );
    img.classList.add("rounded-circle");
    img.style.width = "5ch";
    img.style.height = "5ch";
    img.style.objectFit = "cover";
    img.src = profile_picture;
    img.alt = "Card image cap";

    second_child_div.innerHTML = name;
    small.classList.add("text-muted");
    small.innerHTML = username;

    return entry;
}

async function attendEventClick(
    eventId,
    attendeeId,
    username,
    profile_picture,
    name
) {
    let xmlHTTP = new XMLHttpRequest();
    xmlHTTP.open("POST", "/api/events/" + eventId + "/attendees", false);
    xmlHTTP.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xmlHTTP.onreadystatechange = function () {
        if (xmlHTTP.readyState == 4) {
            if (xmlHTTP.status == 200) {
                let attendee = createSmallCard(username, profile_picture, name);

                let attendees = document.getElementById("attendees-list");
                if (attendees.childElementCount == 1) {
                    attendees.removeChild(attendees.firstElementChild);
                }
                attendees.appendChild(attendee);
            } else {
                alert("Something went wrong");
            }
        }
    };
    xmlHTTP.send("event_id=" + eventId + "&attendee_id=" + attendeeId);
}

async function leaveEventClick(eventId, attendeeId, username) {
    let xmlHTTP = new XMLHttpRequest();

    xmlHTTP.open("DELETE", "/api/events/" + eventId + "/attendees", false);
    xmlHTTP.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xmlHTTP.onreadystatechange = function () {
        if (xmlHTTP.readyState == 4) {
            if (xmlHTTP.status == 200) {
                let attendee = document.getElementById(username + "-entry");
                attendee.parentNode.removeChild(attendee);

                let attendees = document.getElementById("attendees-list");
                if (!attendees.firstElementChild) {
                    let p = document.createElement("p");
                    p.innerHTML = "No attendees around here...";
                    attendees.appendChild(p);
                }
            } else {
                alert("Something went wrong");
            }
        }
    };
    xmlHTTP.send("event_id=" + eventId + "&attendee_id=" + attendeeId);
}

async function addAttendee(
    eventId,
    attendeeId,
    username,
    profile_picture,
    name,
    is_main_btn
) {
    let btn;

    if (is_main_btn) {
        btn = document.getElementById("attend_button");
    } else {
        btn = document.getElementById(username + "-btn");
    }

    if (btn != null) {
        btn.innerHTML =
            '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
        btn.onclick = "";
    }

    await attendEventClick(
        eventId,
        attendeeId,
        username,
        profile_picture,
        name
    );

    if (btn != null && is_main_btn) {
        btn.innerHTML = "Leave event";
        btn.onclick = function () {
            removeAttendee(
                eventId,
                attendeeId,
                username,
                profile_picture,
                name,
                is_main_btn
            );
        };
    }
}

async function removeAttendee(
    eventId,
    attendeeId,
    username,
    profile_picture,
    name,
    is_main_btn
) {
    let btn;

    if (is_main_btn) {
        btn = document.getElementById("attend_button");
    } else {
        btn = document.getElementById(username + "-btn");
    }

    if (btn != null) {
        btn.innerHTML =
            '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
        btn.onclick = "";
    }

    await leaveEventClick(eventId, attendeeId, username);

    if (btn != null && is_main_btn) {
        btn.innerHTML = "Attend event";
        btn.onclick = function () {
            addAttendee(
                eventId,
                attendeeId,
                username,
                profile_picture,
                name,
                is_main_btn
            );
        };
    }
}

function remove(id) {
    let a = $("#" + id)[0];
    if (a != undefined) {
        a.remove();
    }
}

function removeErrors(id) {
    let span = document.getElementById(id + "Error");
    let input = document.getElementById(id);
    if (span != undefined) {
        span.remove();
    }
    if (input != undefined) {
        input.classList.remove("errorBorder");
    }
}
