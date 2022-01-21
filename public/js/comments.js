function deleteComment(eventId, commentId, parentId) {
  fetch('/api/events/' + eventId + '/comments/' + commentId, {
    method: 'DELETE',
  }).then((response) => {
    if (response.ok) {
      const comment = document.getElementById('event_comment_' + commentId);
      if (comment != null) comment.remove();
      if (parentId == null) return;
      const reply_number =
        document.getElementById('comment_' + parentId + '_reply_count');
      const curr_count = parseInt(reply_number.innerHTML);
      reply_number.innerHTML = curr_count - 1;
    }
  });
}

function getComments(parent) {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  fetch('/api/events/' + eventId + '/comments?size=5&parent=' + (parent ?? ''))
    .then((response) => response.text())
    .then((html) => {
      document.getElementById('comment_area').innerHTML = html;
      updateViewMoreCommentsButton();
    });
}

function submitComment() {
  const element_body = document.getElementById('new_comment_body');
  const value = element_body.value;
  if (value === '') return;
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  const data = {
    body: value,
  };
  addRefreshIcon('comment_area', true);
  fetch('/api/events/' + eventId + '/comments', {
    method: 'POST',
    body: JSON.stringify(data),
  })
    .then((response) => response.text())
    .then((html) => {
      element_body.value = '';
    });
}

function submitReply(parent) {
  if (parent == null) return;
  const element_body =
    document.getElementById('comment_' + parent + '_reply_body');
  const value = element_body.value;
  if (value === '') return;
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  const data = {
    body: value,
  };
  fetch('/api/events/' + eventId + '/comments?parent=' + parent, {
    method: 'POST',
    body: JSON.stringify(data),
  })
    .then((response) => response.text())
    .then((html) => {
      document.getElementById('comment_' + parent + '_replies')
        .insertAdjacentHTML('afterbegin', html);
      element_body.value = '';
      const reply_number =
        document.getElementById('comment_' + parent + '_reply_count');
      const curr_count = parseInt(reply_number.innerHTML);
      reply_number.innerHTML = curr_count + 1;
    });
}

function viewMoreComments() {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  const comment_count =
    document.getElementsByClassName('event_parent_comment').length;
  fetch('/api/events/' + eventId + '/comments?start=' + comment_count)
    .then((response) => response.text())
    .then((html) => {
      document.getElementById('comment_area')
        .insertAdjacentHTML('beforeend', html);
      updateViewMoreCommentsButton();
    });
}

function updateViewMoreCommentsButton() {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  const button = document.getElementById('view_more_comments');
  const shown_comments_count =
    document.getElementsByClassName('event_parent_comment').length;
  fetch('/api/events/' + eventId + '/comments/count')
    .then((response) => response.text())
    .then((text) => {
      const all_comments_count = parseInt(text);
      button.style.display =
        all_comments_count > shown_comments_count ? 'block' : 'none';
    });
}

function switchCommentReplyAreaDisplay(commentId) {
  if (parent == null) return;
  const elem = document.getElementById('comment_' + commentId + '_reply_area');
  const hidden = elem.style.display === 'none';
  elem.style.display = hidden ? 'block' : 'none';
}

function prependComment(commentId) {
  const eventId = window.location.pathname.split('/').slice(-1)[0];
  fetch('/api/events/' + eventId + '/comments/' + commentId)
    .then((response) => response.text())
    .then((html) => {
      const comment_area = document.getElementById('comment_area');
      comment_area.insertAdjacentHTML('afterbegin', html);
    });
}
