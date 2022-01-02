/**
 * Reads from an input that has a datalist, and adds one span and hidden input to div
 * @param {*} div -> Div to add the new span elem
 * @param {*} inputId -> Div to read the input from
 * @param {*} arrayId  -> Array id, to add to the hidden input's name field
 */
function addTag(selection, tagsDiv) {
  let selec = document.getElementById(selection)
  let checkbox = document.getElementById(document.getElementById(selec.value).dataset.id)

  if (checkbox.checked !== true) {
    let node = document.createElement("span");
    node.classList = 'tag m-1 removable'
    node.title = "Click to remove"
    node.textContent = selec.value
    node.onclick = function () { removeTag(node) }
    document.getElementById(tagsDiv).append(node)
    checkbox.checked = true

  }
  document.getElementById(selection).value = ''

}

function removeTag(tag) {
  let checkbox = document.getElementById(document.getElementById(tag.textContent.replace(/\s+/g, '')).dataset.id)
  checkbox.checked = false
  tag.remove()
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
        if (xmlHTTP.readyState == 4 && xmlHTTP.status == 200) {
            if (btn != null) {
                btn.innerHTML = "Leave Event";
                btn.onclick = function () {
                    leaveEventClick(eventId, attendeeId);
                };
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
        if (xmlHTTP.readyState == 4 && xmlHTTP.status == 200) {
            if (btn != null) {
                btn.innerHTML = "Attend Event";
                btn.onclick = function () {
                    attendEventClick(eventId, attendeeId, btn_id);
                };
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
