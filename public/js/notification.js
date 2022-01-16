function getNotifications(){
    let refreshId = addRefreshIcon("notifications", true);
    let lastNotification = document.getElementsByClassName("notification");
    if(lastNotification.length > 0){
        lastNotification = lastNotification[0];
    } else {
        lastNotification = null;
    }
    let lastId = lastNotification != null ? lastNotification.id : null;
    let url = "/api/notifications";
    if(lastId != null){
        url += "?lastSeen="+lastNotification;
    }

    let  options = {
        method: 'get'
      };
    fetch(url, options)
    .then((response) => response.text())
    .then(html => {
        remove(refreshId);
        let notifications = document.getElementById("notifications");
        notifications.insertAdjacentHTML('beforeend', html);
        remove("notificationCount");
        refreshCounter();
    });
}

function getPastNotifications(){
    remove("emptyNotifications");
    let refreshId = addRefreshIcon("notifications", false);
    let notifications = document.getElementsByClassName("notification");
    let url = "/api/notifications/past";
    let offset = notifications.length;
    let size = 10;
    url += "?" + "offset=" + offset + "&size="+size;

    let  options = {
        method: 'get'
      };
    fetch(url, options)
    .then((response) => response.text())
    .then(html => {
        remove(refreshId);
        let notifications = document.getElementById("notifications");

        notifications.insertAdjacentHTML('beforeend', html);


        let n = document.getElementById("notificationCount").innerText;
        if(parseInt(n) < size){
            remove("getPastNotifications");
        remove(document.getElementById("notificationCount"));
        }
    });
}
function readNotifications(){
    let url = "/api/notifications/read";
    let notIds = [];
    let nots = document.getElementsByClassName("notification");
    for(var i=0; i<nots.length; i++){
        if(nots[i].getAttribute('seen') != "1"){
            let id = parseInt(nots[i].id.replace("notification", ""));
            notIds.push(id);
        }
    }
    if(notIds.length == 0){
        return;
    }
    let data = {ids: notIds};
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
        notIds.forEach(function(currentValue, index, arr){
            markAsReadOrUnread(currentValue, 1);
        });
        refreshCounter();
    });
}

function notificationEdit(id, isRead){
    let url = "/api/notifications/" + id;
    let data = {is_seen: isRead};
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
        markAsReadOrUnread(id, isRead);
        refreshCounter();

    });
}

function notificationDelete(id){
    let url = "/api/notifications/" + id;
    let  options = {
        method: 'delete',
        headers: {
            "X-CSRF-Token": $('input[name="_token"]').val()
        }

      };
    fetch(url, options)
    .then((response) => response.text())
    .then(html => {

        notification = document.getElementById("notification" + id);
        remove("notification" + id);
        refreshCounter();
    });
}

/**
 * Adds a refresh icon, returns it's id
 * @param {} divId
 * @returns
 */
 function addRefreshIcon(divId, atBeginning){
    let div = document.getElementById(divId);
    if(div != null){
        let arrow = document.createElement('div');
        arrow.classList.add("bi");
        arrow.classList.add("bi-arrow-clockwise");
        arrow.classList.add("mx-auto");
        arrow.classList.add("rotating");
        arrow.id = divId + ":" + "refreshIcon";
        div.insertAdjacentElement(atBeginning ? "afterbegin" : "beforeend", arrow);
        return arrow.id;
    }
    return divId;
}

function remove(id) {
    let a = document.getElementById(id);
    if (a != undefined) {
        a.remove();
    }
}

function markAsReadOrUnread(id, isRead){
    notification = document.getElementById("notification" + id);
    notification.setAttribute('seen', isRead ? 1 : 0);
    let option = document.getElementById('markAsRead' + id);
    option.innerHTML = isRead ? "Mark as unread" : "Mark as read";
    option.onclick = function(){
        notificationEdit(id, isRead == 0);
    }
}


function refreshCounter(){
    let notSeen = document.querySelectorAll(".notification[seen='0']").length;
    let counter = document.getElementById("notificationCounter");
    counter.innerHTML = notSeen;
}
