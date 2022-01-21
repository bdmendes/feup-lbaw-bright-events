function changePollVote(pollId, optionId) {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  const is_delete =
      !document.getElementById('poll_' + pollId + '_option_' + optionId)
           .checked;
  fetch('/api/events/' + eventId + '/polls/' + pollId + '/' + optionId, {
    method: is_delete ? 'DELETE' : 'POST',
  }).then((response) => {
    if (!response.ok) {
      return;
    }
    const elem = document.getElementById('option_' + optionId + '_voter_count');
    const curr_count = parseInt(elem.innerHTML);
    elem.innerHTML = is_delete ? curr_count - 1 : curr_count + 1;
  });
}

function updatePollOptionFields(optionNumber) {
  const curr_count = document.getElementsByClassName('new_poll_option').length;
  const elem = document.getElementById('new_poll_option_' + optionNumber);
  const is_empty = elem.value.length === 0;
  const poll_option_area = document.getElementById('new_poll_options_area');
  const is_last_child = elem.nextElementSibling == null;
  const is_next_to_last_child =
      !is_last_child && elem.nextElementSibling.nextElementSibling == null;
  if (is_empty) {
    if (curr_count <= 1 || !is_next_to_last_child) return;
    poll_option_area.removeChild(poll_option_area.lastChild);
  } else {
    if (!is_last_child) return;
    const new_elem = document.createElement('input');
    new_elem.classList.add('input');
    new_elem.type = "text";
    const new_id_option = (optionNumber + 1);
    new_elem.id = 'new_poll_option_' + new_id_option;
    new_elem.placeholder = 'Enter option ' + new_id_option;
    new_elem.oninput = () => updatePollOptionFields(new_id_option);
    new_elem.onclick = () => updatePollOptionFields(new_id_option);
    poll_option_area.append(new_elem);
  }
}

function resetPollForm() {
  const poll_form = document.getElementById('new_poll_form');
  poll_form.reset();
  const poll_option_area = document.getElementById('new_poll_options_area');
  while (poll_option_area.childElementCount >= 3) {
    poll_option_area.removeChild(poll_option_area.lastChild);
  }
}

function submitPoll() {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  const options = [];
  const optionFields = document.getElementsByClassName('new_poll_option');
  for (let option of optionFields) {
    if (option.value == '') continue;
    options.push(option.value);
  }
  const data = {
    title: document.getElementById('new_poll_title').value,
    description: document.getElementById('new_poll_description').value,
    options: options
  };
  fetch('/api/events/' + eventId + '/polls', {
    method: 'POST',
    body: JSON.stringify(data),
  }).then(async response => {
    if (!response.ok) {
      const form = document.getElementById('new_poll_form');
      const error_message = document.createElement('h4');
      error_message.classList.add('mt-4');
      error_message.classList.add('mb-0');
      error_message.innerHTML = 'Please fill all the fields properly!';
      form.insertAdjacentElement('beforeend', error_message);
      setTimeout(() => {
        form.removeChild(error_message);
      }, 5000);
      return;
    }
    const html = await response.text();
    const poll_area = document.getElementById('poll_area');
    poll_area.insertAdjacentHTML('afterbegin', html);
    document.getElementById('new_poll_button').click();
    resetPollForm();
  });
}

function getPolls() {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  fetch('/api/events/' + eventId + '/polls')
      .then((response) => response.text())
      .then((html) => {
        document.getElementById('poll_area').innerHTML = html;
        expandPollEntry();
      });
}

function deletePoll(pollId) {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  fetch('/api/events/' + eventId + '/polls/' + pollId, {
    method: 'DELETE'
  }).then((response) => {
    if (!response.ok) return;
    const poll_entry = document.getElementById('poll_' + pollId + '_entry');
    poll_entry.remove();
  })
}

function expandPollEntry(pollId) {
  const collapsed = pollId == null ?
      document.querySelector('#poll_area .accordion-collapse') :
      document.getElementById('poll_' + pollId + '_item_body');
  if (collapsed === null) return;
  collapsed.classList.add('show');
}

function updatePoll(pollId) {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  const poll_entry = document.getElementById('poll_' + pollId + '_entry');
  fetch('/api/events/' + eventId + '/polls/' + pollId, {method: 'GET'})
      .then((response) => response.text())
      .then((html) => {
        poll_entry.insertAdjacentHTML('beforebegin', html);
        poll_entry.remove();
        expandPollEntry(pollId);
      });
}

function switchPollState(pollId) {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  fetch('/api/events/' + eventId + '/polls/' + pollId, {
    method: 'POST'
  }).then((response) => {
    if (!response.ok) return;
    updatePoll(pollId);
  })
}
