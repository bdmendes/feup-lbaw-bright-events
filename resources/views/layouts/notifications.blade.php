<div class="btn-group">
    <a class="bi bi-bell-fill notification-bell"
        id="notificationBell"
    data-bs-toggle="dropdown"
    data-bs-auto-close="outside"
    aria-expanded="false">
    <div class="notification-count align-items-center  justify-content-center d-flex">0</div>
    </a>
    <ul
    class="dropdown-menu dropdown-menu-end notification-panel p-0"
    aria-labelledby="notificationBell">

        <div  id="notifications" class="w-100">
            <script>
                getNotifications();
            </script>
        </div>
        <div class="w-100 justify-content-center mt-4">
            <button class="btn-primary"> Load more </button>
        </div>
    </ul>
</div>
