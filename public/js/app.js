/*
function addEventListeners() {
  let itemCheckers = document.querySelectorAll('article.card li.item input[type=checkbox]');
  [].forEach.call(itemCheckers, function(checker) {
    checker.addEventListener('change', sendItemUpdateRequest);
  });

  let itemCreators = document.querySelectorAll('article.card form.new_item');
  [].forEach.call(itemCreators, function(creator) {
    creator.addEventListener('submit', sendCreateItemRequest);
  });

  let itemDeleters = document.querySelectorAll('article.card li a.delete');
  [].forEach.call(itemDeleters, function(deleter) {
    deleter.addEventListener('click', sendDeleteItemRequest);
  });

  let cardDeleters = document.querySelectorAll('article.card header a.delete');
  [].forEach.call(cardDeleters, function(deleter) {
    deleter.addEventListener('click', sendDeleteCardRequest);
  });

  let cardCreator = document.querySelector('article.card form.new_card');
  if (cardCreator != null)
    cardCreator.addEventListener('submit', sendCreateCardRequest);
}

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function sendItemUpdateRequest() {
  let item = this.closest('li.item');
  let id = item.getAttribute('data-id');
  let checked = item.querySelector('input[type=checkbox]').checked;

  sendAjaxRequest('post', '/api/item/' + id, {done: checked}, itemUpdatedHandler);
}

function sendDeleteItemRequest() {
  let id = this.closest('li.item').getAttribute('data-id');

  sendAjaxRequest('delete', '/api/item/' + id, null, itemDeletedHandler);
}

function sendCreateItemRequest(event) {
  let id = this.closest('article').getAttribute('data-id');
  let description = this.querySelector('input[name=description]').value;

  if (description != '')
    sendAjaxRequest('put', '/api/cards/' + id, {description: description}, itemAddedHandler);

  event.preventDefault();
}

function sendDeleteCardRequest(event) {
  let id = this.closest('article').getAttribute('data-id');

  sendAjaxRequest('delete', '/api/cards/' + id, null, cardDeletedHandler);
}

function sendCreateCardRequest(event) {
  let name = this.querySelector('input[name=name]').value;

  if (name != '')
    sendAjaxRequest('put', '/api/cards/', {name: name}, cardAddedHandler);

  event.preventDefault();
}

function itemUpdatedHandler() {
  let item = JSON.parse(this.responseText);
  let element = document.querySelector('li.item[data-id="' + item.id + '"]');
  let input = element.querySelector('input[type=checkbox]');
  element.checked = item.done == "true";
}

function itemAddedHandler() {
  if (this.status != 200) window.location = '/';
  let item = JSON.parse(this.responseText);

  // Create the new item
  let new_item = createItem(item);

  // Insert the new item
  let card = document.querySelector('article.card[data-id="' + item.card_id + '"]');
  let form = card.querySelector('form.new_item');
  form.previousElementSibling.append(new_item);

  // Reset the new item form
  form.querySelector('[type=text]').value="";
}

function itemDeletedHandler() {
  if (this.status != 200) window.location = '/';
  let item = JSON.parse(this.responseText);
  let element = document.querySelector('li.item[data-id="' + item.id + '"]');
  element.remove();
}

function cardDeletedHandler() {
  if (this.status != 200) window.location = '/';
  let card = JSON.parse(this.responseText);
  let article = document.querySelector('article.card[data-id="'+ card.id + '"]');
  article.remove();
}

function cardAddedHandler() {
  if (this.status != 200) window.location = '/';
  let card = JSON.parse(this.responseText);

  // Create the new card
  let new_card = createCard(card);

  // Reset the new card input
  let form = document.querySelector('article.card form.new_card');
  form.querySelector('[type=text]').value="";

  // Insert the new card
  let article = form.parentElement;
  let section = article.parentElement;
  section.insertBefore(new_card, article);

  // Focus on adding an item to the new card
  new_card.querySelector('[type=text]').focus();
}

function createCard(card) {
  let new_card = document.createElement('article');
  new_card.classList.add('card');
  new_card.setAttribute('data-id', card.id);
  new_card.innerHTML = `

  <header>
    <h2><a href="cards/${card.id}">${card.name}</a></h2>
    <a href="#" class="delete">&#10761;</a>
  </header>
  <ul></ul>
  <form class="new_item">
    <input name="description" type="text">
  </form>`;

  let creator = new_card.querySelector('form.new_item');
  creator.addEventListener('submit', sendCreateItemRequest);

  let deleter = new_card.querySelector('header a.delete');
  deleter.addEventListener('click', sendDeleteCardRequest);

  return new_card;
}

function createItem(item) {
  let new_item = document.createElement('li');
  new_item.classList.add('item');
  new_item.setAttribute('data-id', item.id);
  new_item.innerHTML = `
  <label>
    <input type="checkbox"> <span>${item.description}</span><a href="#" class="delete">&#10761;</a>
  </label>
  `;

  new_item.querySelector('input').addEventListener('change', sendItemUpdateRequest);
  new_item.querySelector('a.delete').addEventListener('click', sendDeleteItemRequest);

  return new_item;
}

addEventListeners();
*/

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

async function addAttendee(eventId, attendeeId, btn_id) {
    let btn = document.getElementById(btn_id);

    if (btn != null) {
        btn.innerHTML = "<div class=\"spinner-border\" role=\"status\"><span class=\"sr-only\"></span></div>";
        btn.onclick = "";
    }

    let xmlHTTP = new XMLHttpRequest();
    xmlHTTP.open("POST", "/api/events/" + eventId + "/attendees", false);
    xmlHTTP.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xmlHTTP.onreadystatechange = function() {
        if(xmlHTTP.readyState == 4 && xmlHTTP.status == 200) {
            if (btn != null) {
                btn.innerHTML = "Leave Event";
                btn.onclick = function () { removeAttendee(eventId, attendeeId); }
            }
        }
    }
    xmlHTTP.send("event_id=" + eventId + "&attendee_id=" + attendeeId);
}

async function removeAttendee(eventId, attendeeId, btn_id) {
    let btn = document.getElementById(btn_id);

    if (btn != null) {
        btn.innerHTML = "<div class=\"spinner-border\" role=\"status\"><span class=\"sr-only\"></span></div>";
        btn.onclick = "";
    }

    let xmlHTTP = new XMLHttpRequest();

    xmlHTTP.open("DELETE", "/api/events/" + eventId + "/attendees", false);
    xmlHTTP.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xmlHTTP.onreadystatechange = function() {
        if(xmlHTTP.readyState == 4 && xmlHTTP.status == 200) {
            if (btn != null) {
                btn.innerHTML = "Attend Event";
                btn.onclick = function () { addAttendee(eventId, attendeeId, btn_id); }
            }
        }
    }
    xmlHTTP.send("event_id=" + eventId + "&attendee_id=" + attendeeId);
}

async function removeAndUpdate(eventId, attendeeId, username) {
    removeAttendee(eventId, attendeeId, username + "-btn");

    let div = document.getElementById(username);
    let parent = div.parentElement;
    parent.removeChild(div);

    if (!parent.firstElementChild) {
        let p = document.createElement('p');
        p.innerHTML = "No attendees around here...";
        parent.appendChild(p);
    }
}


function remove(id){
    let a = $("#" + id)[0];
    if(a != undefined){
        a.remove();
    }
}

function removeErrors(id){
    let span = $("#"+id+"Error");
    let input = $("#" + id + ".errorBorder");
    if(span != undefined){
        span.remove();
    }
    if(input != undefined){
        input.removeClass("errorBorder");
    }
}
