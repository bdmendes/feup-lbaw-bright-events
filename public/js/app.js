/**
 * Reads from an input that has a datalist, and adds one span and hidden input to div
 * @param {*} div -> Div to add the new span elem
 * @param {*} inputId -> Div to read the input from
 * @param {*} arrayId  -> Array id, to add to the hidden input's name field
 */
function addItem(div, inputId, arrayId) {
    let a = document.getElementById(inputId);
    let value = a.value;
    let data_value = $("option[value='" + value + "']").data("value");
    if (data_value == undefined) return;
    div = $("#" + div)[0];
    let span = div.querySelector("span.hidden");

    let newSpan = span.cloneNode(true);
    newSpan.classList.remove("hidden");
    newSpan.innerHTML = value;
    if ($("#" + inputId + data_value).length > 0) {
        return;
    }
    div.append(newSpan);

    //Add input to form
    let inputHtml =
        "<input type='hidden' name ='" +
        arrayId +
        "[]' id='tag" +
        data_value +
        "' value='" +
        data_value +
        " '> </input>";
    div.insertAdjacentHTML("afterBegin", inputHtml);
}

function removeTag(t) {
    let tagId = t.attributes["value"].value;
    let hiddenInput = $("#tag" + tagId);
    hiddenInput.remove();
    t.remove();
}

function clearValue(id) {
    $("#" + id)[0].value = "";
}

async function attendEventClick(eventId, attendeeId, btnId) {
    let btn = document.getElementById(btnId);

    if (btn != null) {
        btn.innerHTML =
            '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
        btn.onclick = "";
    }

    let xmlHTTP = new XMLHttpRequest();
    xmlHTTP.open("POST", "/api/events/" + eventId + "/attendees", false);
    xmlHTTP.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xmlHTTP.onreadystatechange = function () {
        if (xmlHTTP.readyState == 4) {
            if (xmlHTTP.status == 200) {
                if (btn != null) {
                    btn.innerHTML = "Leave Event";
                    btn.onclick = function () {
                        leaveEventClick(eventId, attendeeId);
                    };
                }
            } else {
                alert('Something went wrong');
            }
        }
    };
    xmlHTTP.send("event_id=" + eventId + "&attendee_id=" + attendeeId);
}

async function leaveEventClick(eventId, attendeeId, btn_id) {
    let btn = document.getElementById(btn_id);

    if (btn != null) {
        btn.innerHTML =
            '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
        btn.onclick = "";
    }

    let xmlHTTP = new XMLHttpRequest();

    xmlHTTP.open("DELETE", "/api/events/" + eventId + "/attendees", false);
    xmlHTTP.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xmlHTTP.onreadystatechange = function () {
        if (xmlHTTP.readyState == 4) {
            if (xmlHTTP.status == 200) {
                if (btn != null) {
                    btn.innerHTML = "Leave Event";
                    btn.onclick = function () {
                        leaveEventClick(eventId, attendeeId);
                    };
                }
            } else {
                alert('Something went wrong');
            }
        }
    };
    xmlHTTP.send("event_id=" + eventId + "&attendee_id=" + attendeeId);
}

async function removeAttendance(eventId, attendeeId, username) {
    leaveEventClick(eventId, attendeeId, username + "-btn");

    let div = document.getElementById(username + "-entry");
    let parent = div.parentElement;
    parent.removeChild(div);

    if (!parent.firstElementChild) {
        let p = document.createElement("p");
        p.innerHTML = "No attendees around here...";
        parent.appendChild(p);
    }
}

function remove(id) {
    let a = $("#" + id)[0];
    if (a != undefined) {
        a.remove();
    }
}

function removeErrors(id) {
    let span = $("#" + id + "Error");
    let input = $("#" + id + ".errorBorder");
    if (span != undefined) {
        span.remove();
    }
    if (input != undefined) {
        input.removeClass("errorBorder");
    }
}
