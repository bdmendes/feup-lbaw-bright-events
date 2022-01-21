/**
 * Reads from an input that has a datalist, and adds one span and hidden input
 * to div
 * @param {*} div -> Div to add the new span elem
 * @param {*} inputId -> Div to read the input from
 * @param {*} arrayId  -> Array id, to add to the hidden input's name field
 */
function addTag(selection, tagsDiv) {
  let selec = document.getElementById(selection);
  let checkbox =
      document.getElementById(document.getElementById(selec.value).dataset.id);
  let div = document.getElementById(tagsDiv);

  if (checkbox.checked !== true) {
    let node = document.getElementById('tagEx').cloneNode();
    node.classList.remove('d-none');
    node.textContent = selec.value;
    div.append(node);
    checkbox.checked = true;
  }

  document.getElementById(selection).value = '';
}

function removeTag(tag) {
  let checkbox = document.getElementById(
      document.getElementById(tag.textContent.replace(/\s+/g, '')).dataset.id);
  checkbox.checked = false;
  tag.remove();
}

async function attendEventClick(eventId, attendeeId, username) {
  let xmlHTTP = new XMLHttpRequest();
  xmlHTTP.open('POST', '/api/events/' + eventId + '/attendees', false);
  xmlHTTP.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xmlHTTP.onreadystatechange = function() {
    if (xmlHTTP.readyState == 4) {
      if (xmlHTTP.status == 200) {
        let html = JSON.parse(xmlHTTP.response).html;

        let parser = new DOMParser();
        let attendee =
            parser.parseFromString(html, 'text/html').body.firstChild;

        let div = document.createElement('div');
        div.classList.add('border', 'rounded', 'd-flex', 'p-1');
        div.style.width = '250px';
        div.id = username + '-entry';
        div.appendChild(attendee);

        let attendees = document.getElementById('attendees-list');
        if (attendees.childElementCount == 1) {
          attendees.removeChild(attendees.firstElementChild);
        }
        attendees.appendChild(div);
      }
    }
  };
  xmlHTTP.send('event_id=' + eventId + '&attendee_id=' + attendeeId);
}

async function leaveEventClick(eventId, attendeeId, username) {
  let xmlHTTP = new XMLHttpRequest();

  xmlHTTP.open('DELETE', '/api/events/' + eventId + '/attendees', false);
  xmlHTTP.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xmlHTTP.onreadystatechange = function() {
    if (xmlHTTP.readyState == 4) {
      if (xmlHTTP.status == 200) {
        let attendee = document.getElementById(username + '-entry');
        attendee.parentNode.removeChild(attendee);

        let attendees = document.getElementById('attendees-list');
        if (!attendees.firstElementChild) {
          let p = document.createElement('p');
          p.innerHTML = 'No attendees around here...';
          attendees.appendChild(p);
        }
      }
    }
  };
  xmlHTTP.send('event_id=' + eventId + '&attendee_id=' + attendeeId);
}

async function addAttendee(
    eventId, attendeeId, username, is_main_btn, makeRequest = true) {
  let btn;

  if (is_main_btn) {
    btn = document.getElementById('attend_button');
  } else {
    btn = document.getElementById(username + '-btn');
  }

  if (btn != null) {
    btn.innerHTML =
        '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
    btn.onclick = '';
  }
  if (makeRequest) await attendEventClick(eventId, attendeeId, username);

  if (btn != null && is_main_btn) {
    btn.innerHTML = 'Leave event';
    btn.onclick = function() {
      removeAttendee(eventId, attendeeId, username, is_main_btn);
    };
  }
}

async function removeAttendee(eventId, attendeeId, username, is_main_btn) {
  let btn;

  if (is_main_btn) {
    btn = document.getElementById('attend_button');
  } else {
    btn = document.getElementById(username + '-btn');
  }

  if (btn != null) {
    btn.innerHTML =
        '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
    btn.onclick = '';
  }

  await leaveEventClick(eventId, attendeeId, username);

  if (btn != null && is_main_btn) {
    btn.innerHTML = 'Attend event';
    btn.onclick = function() {
      addAttendee(eventId, attendeeId, username, is_main_btn);
    };
  }
}



function remove(id) {
  let a = document.getElementById(id);
  if (a != undefined) {
    a.remove();
  }
}

function removeErrors(id) {
  let span = document.getElementById(id + 'Error');
  let input = document.getElementById(id);
  if (span != undefined) {
    span.remove();
  }
  if (input != undefined) {
    input.classList.remove('errorBorder');
  }
}

function trimEnd(s, mask) {
  while (~mask.indexOf(s[s.length - 1])) {
    s = s.slice(0, -1);
  }
  return s;
}

function replaceHash(str) {
  window.location.hash = str;
}

function answerJoinRequest(eventId, requestId, accept){
    let url = "/api/events/" + eventId + "/join-requests/"+ requestId;
    let data = {'accept' : accept};
    let  options = {
        method: 'post',
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-Token": $('input[name="_token"]').val()
        }
      };
    fetch(url, options)
    .then((response) => response.text())
    .then(html => {
        let divId = "joinRequest"+requestId;
        let username = document.querySelector("#"+divId + " .text-muted").innerText;
        remove("joinRequest"+username);
        if(accept){
            let div = document.createElement("div");
            div.classList.add("border", "rounded", "d-flex", "p-1");
            div.style.width = "250px";
            div.id = username + "-entry";
            div.insertAdjacentHTML('beforeend', html);

            let attendees = document.getElementById("attendees-list");
            if (attendees.childElementCount == 1) {
                attendees.removeChild(attendees.firstElementChild);
            }
            attendees.appendChild(div);
        }

    });
}
