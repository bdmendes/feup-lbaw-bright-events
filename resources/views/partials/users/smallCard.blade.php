<a href="{{ isset($user) ? route('profile', ['username' => $user->username]) : '#' }}"
    class="d-flex justify-content-start align-items-center gap-4 text-dark" style="text-decoration: none;">
    <div>
        <img class="rounded-circle" style="width:5ch; height:5ch; object-fit:cover;"
            src="{{ !empty($user->profile_picture) ? '/' . $user->profile_picture->path : '/images/user.png' }}"
            alt="Card image cap">
    </div>
    <div>
        <div> {{ $user->name ?? 'Deleted user' }} </div>
        <small class="text-muted"> {{ $user->username ?? '' }} </small>
    </div>
</a>
