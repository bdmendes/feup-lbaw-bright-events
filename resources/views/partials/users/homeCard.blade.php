<a href="{{ route('profile', ['username' => $user->username]) }}" class="card text-dark trending-org d-flex flex-column flex-grow-1"
    style="text-decoration: none; width: 12em;">
    <img class="mt-2 rounded-circle"
        src="{{ !empty($user->profile_picture) ? '/' . $user->profile_picture->path : '/images/user.png' }}">
        <hr>
    <div class="card-body pt-0">
        <span>
            <h2 class="card-title">{{ $user->name }}</h2>
            <h5 class="text-muted"> {{ $user->username }}</h5>
        </span>
    </div>
</a>
