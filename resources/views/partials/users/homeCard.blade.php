<a href="{{ route('profile', ['username' => $user->username]) }}" class="card text-dark trending-org w-25"
    style="text-decoration: none; width: 12em;">
    <img class="mt-2 rounded-circle" style="width:100%; object-fit:cover;"
        src="{{ !empty($user->profile_picture) ? '/' . $user->profile_picture->path : '/images/user.png' }}">
    <div class="card-body">
        <h3 class="card-title">{{ $user->name }}</h3>
        <h5 class="card-text"> {{ $user->username }}</h5>
    </div>
</a>
