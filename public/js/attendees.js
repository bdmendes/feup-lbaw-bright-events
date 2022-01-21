function getAttendees() {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  fetch('/api/events/' + eventId + '/attendees')
      .then((response) => response.text())
      .then((html) => {
        document.getElementById('attendees-list').innerHTML = html;
        updateViewMoreAttendeesButton();
      });
}

function viewMoreAttendees() {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  const attendees_count =
      document.getElementsByClassName('event_attendant').length;
  fetch('/api/events/' + eventId + '/attendees?start=' + attendees_count)
      .then((response) => response.text())
      .then((html) => {
        document.getElementById('attendees-list')
            .insertAdjacentHTML('beforeend', html);
        updateViewMoreAttendeesButton();
      });
}

function updateViewMoreAttendeesButton() {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  const button = document.getElementById('view_more_attendees');
  const shown_attendees_count =
      document.getElementsByClassName('event_attendant').length;
  fetch('/api/events/' + eventId + '/attendees/count')
      .then((response) => response.text())
      .then((text) => {
        const all_attendees_count = parseInt(text);
        button.style.display =
            all_attendees_count > shown_attendees_count ? 'block' : 'none';
      });
}
