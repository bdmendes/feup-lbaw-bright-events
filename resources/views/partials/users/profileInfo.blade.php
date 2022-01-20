        <div class="d-flex flex-column justify-content-center">
            @if (is_null($user->profile_picture_id))
                <img src="/images/user.png" alt="Generic Profile Picture" class="rounded-circle w-100"
                    style="object-fit: cover; max-width: 400px">
            @else
                <img src="/{{ $user->profile_picture->path }}" alt="{{ $user->name }}'s Profile Picture"
                    class="mb-3 rounded-circle" style="object-fit: cover; max-width: 400px">
            @endif
        </div>
        <div class="info w-100 px-3">
            <span class="d-inline-flex justify-content-between w-100">
                <div class="d-flex flex-column">
                    <h1>{{ $user->name }}</h1>
                    <h3>{{ $user->username }}</h3>
                </div>
                <div class="d-flex flex-row">
                    @if (Auth::check())
                        @if (Auth::check() && Auth::id() != $user->id)
                        <div class="m-3 text-decoration-none d-flex flex-column align-items-center" onclick="getReportModal('user', {{ $user->id }});" type="button">
                            <i class="bi bi-exclamation-triangle"></i>
                            <p>Report user</p>
                        </div>
                        @endif
                        @if ((Auth::user()->is_admin || Auth::user()->id === $user->id) && !$user->is_admin)
                            @if (Auth::user()->is_admin)
                                <form method="POST"
                                    action="{{ route('profile', ['username' => $user->username]) }}"
                                    style="cursor: pointer">
                                    @csrf

                                    <input type="hidden" value={{ $user->is_blocked ? 1 : 0 }}
                                        name="is_blocked" />
                                    <a onclick="this.parentNode.submit();"
                                        class="m-3 text-decoration-none d-flex flex-column align-items-center">
                                        @if ($user->is_blocked)
                                            <i class="bi bi-check-circle"></i>
                                            <p>Unblock</p>
                                        @else
                                            <i class="bi bi-dash-circle"></i>
                                            <p>Block</p>
                                        @endif
                                    </a>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('profile', ['username' => $user->username]) }}">
                                @csrf
                                @method('DELETE')
                                <a onclick="this.parentNode.submit();"
                                    class="m-3 text-decoration-none d-flex flex-column align-items-center"
                                    style="cursor: pointer">
                                    <i class="bi bi-trash"></i>
                                    <p>Remove</p>
                                </a>
                            </form>
                            @if (Auth::user()->id === $user->id)
                                <a href="{{ route('editProfile', ['username' => Auth::user()->username]) }}"
                                    class="m-3 text-decoration-none d-flex flex-column align-items-center">
                                    <i class="bi bi-pencil-square"></i>
                                    <p>Edit</p>
                                </a>
                            @endif
                        @endif
                    @endif
                </div>
            </span>
            @if (!is_null($user->bio))
                <p>{{ $user->bio }}</p>
            @endif
            @if (!is_null($user->birth_date))
                <p>Born in: {{$user->birth_date}}</p>
            @endif
            @if (!is_null($user->gender))
                <p>Gender: {{$user->gender}}</p>
            @endif
        </div>
