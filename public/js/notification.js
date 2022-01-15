function getNotifications(){
    console.log("Teste");
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
    console.log(url);

    let  options = {
        method: 'get'
      };
    fetch(url, options)
    .then((response) => response.text())
    .then(html => {
        let notifications = document.getElementById("notifications");
        notifications.innerHTML = html + notifications.innerHTML;
    });

}
