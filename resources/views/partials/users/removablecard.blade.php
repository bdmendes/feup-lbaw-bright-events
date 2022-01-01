<div id="{{$user->username}}" class="card text-dark p-3">
    <a href="{{ route('profile', ['username' => $user->username]) }}" class=" text-decoration-none mb-3"style="text-decoration: none; width: 20rem;">
        <img class="rounded-circle" src=" https://marriedbiography.com/wp-content/uploads/2021/01/Linus-Torvalds.jpg">
    </a>
    <div class="d-flex flex-row justify-content-between align-items center">
        <div>
            <h3 class="card-title">{{ $user->name }}</h3>
            <h5 class="card-text"> {{ $user->username }}</h5>
        </div>
        <button id="{{$user->username . "-btn"}}"class="btn btn-light" onclick="removeAndUpdate({{$event->id}}, {{$user->id}}, '{{$user->username}}')">
            <i class="bi bi-x-circle"></i>
        </button>
    </div>
</div>
