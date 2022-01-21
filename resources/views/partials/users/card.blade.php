<a href="{{ route('profile', ['username' => $user->username]) }}" class="card text-dark d-flex flex-column p-2 w-100 h-100"
    style="text-decoration: none; width: 12em;">
    <img class="mt-2 rounded-circle" style="width:100%; object-fit:cover;" src="{{ !empty($user->profile_picture) ? '/' . $user->profile_picture->path : '/images/user.png' }}">
    <hr>
    <div class="card-body">
        <h2 class="card-title">{{ $user->name }}</h2>
        <h5 class="card-text text-muted"> {{ $user->username }}</h5>
    </div>
</a>
