<div class="btn-group">
    <a class="bi bi-bell-fill clickableIcon"
        id="notificationBell"
    data-bs-toggle="dropdown"
    data-bs-auto-close="outside"
    onclick="readNotifications()"
    aria-expanded="false">
    <div id="notificationCounter" class="notification-count align-items-center  justify-content-center d-flex">0</div>
    </a>
    <ul
    class="dropdown-menu dropdown-menu-end notification-panel p-0"
    aria-labelledby="notificationBell">

        <div  id="notifications" class="w-100">
            <script>
                window.addEventListener('load', getNotifications);
                </script>
        </div>
        <div class="w-100 d-flex justify-content-center my-2">
            <button id="getPastNotifications" class="btn-primary"
            onclick="getPastNotifications();"> Load more </button>
        </div>
    </ul>
</div>
