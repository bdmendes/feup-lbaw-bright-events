<div class="d-flex justify-content-start align-items-center gap-4">
    <div>
        <img class="rounded-circle" style="width:5ch; height:5ch; object-fit:cover;"
            src="{{ !empty($user->profile_picture) ? '/' . $user->profile_picture->path : 'https://marriedbiography.com/wp-content/uploads/2021/01/Linus-Torvalds.jpg' }}"
            alt="Card image cap">
    </div>
    <div>
        <div> {{ $user->name ?? 'Deleted user' }} </div>
        <small class="text-muted"> {{ $user->username ?? '' }} </small>
    </div>
</div>
