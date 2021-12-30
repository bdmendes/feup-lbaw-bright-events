<div class="container-fluid bg-light">
    <nav class="navbar navbar-expand-lg navbar-light py-4" role="navigation">
        <a class="navbar-brand" href="#"><h1>Bright Events Logo</h1></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsable" aria-controls="collapsable" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="collapsable" class="collapse navbar-collapse">
            <a class="nav-item nav-link" href="{{ url('events')}}"><h2>Events</h2></a>
            <a class="nav-item nav-link" href="{{ url('users')}}"><h2>Users</h2></a>
            @if (Auth::check())
            <a class="nav-item nav-link" href="{{ url('/logout') }}"><h2>Logout</h2></a>
            <a class="nav-item nav-link" href="{{route('profile', ['username' => Auth::user()->username])}}"><h2>{{ Auth::user()->name }}</h2></a>
            @else
            <a class="nav-item nav-link" href="{{url('login') }}"><h2>Login</h2></a>
            @endif
        </div>
    </nav>
</div>

@yield('navbar')
