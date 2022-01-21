    <nav class="navbar navbar-expand-md navbar-light py-4 fixed-top d-flex align-items-center justify-content-start"
        role="navigation" id="navbar">
        <a class="navbar-brand" href=" {{ route('home') }} ">
            <h1><span class="highlight">B</span>right Events</h1>
        </a>
        <a class="nav-item nav-link" href="{{ route('browseEvents') }}">
            <h2>Events</h2>
        </a>
        <a class="nav-item nav-link me-auto" href="{{ route('browseUsers') }}">
            <h2>Users</h2>
        </a>
        @if (Auth::check())
            <div class="me-4">
                @include('layouts.notifications')
            </div>
        @endif
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsable"
            aria-controls="collapsable" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="collapsable" class="collapse navbar-collapse flex-grow-0">
            @if (Auth::check())
                @if (Auth::user()->is_admin)
                    <a class="nav-item nav-link" href="{{ route('reportsDash') }}">
                        <h2>Dashboard</h2>
                    </a>
                @else
                    <a class="nav-item nav-link"
                        href="{{ route('profile', ['username' => Auth::user()->username]) }}">
                        <h2>{{ Auth::user()->name }}</h2>
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="post" style="margin: 0; padding: 0;">
                    @csrf
                    <a class="nav-item nav-link" href="javascript:;" onclick="this.parentNode.submit();">
                        <h2>Logout</h2>
                    </a>
                </form>
            @else
                <a class="nav-item nav-link" href="{{ route('login') }}">
                    <h2>Login</h2>
                </a>
            @endif
        </div>
        @include('partials.breadcrumbs')
    </nav>

    @yield('navbar')
