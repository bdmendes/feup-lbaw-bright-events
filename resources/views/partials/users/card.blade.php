<a href="{{ route('profile', ['username' => $user->username]) }}" class="card text-dark"
    style="text-decoration: none; width: 12em;">
    <img class="rounded-circle" src=" https://marriedbiography.com/wp-content/uploads/2021/01/Linus-Torvalds.jpg">
    <div class="card-body">
        <h3 class="card-title">{{ $user->name }}</h3>
        <h5 class="card-text"> {{ $user->username }}</h5>
    </div>
</a>
