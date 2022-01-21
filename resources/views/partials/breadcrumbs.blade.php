<nav class="p-3" aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach ($pages as $page)
            @if ($loop->last)
                <li class="breadcrumb-item active" aria-current="page"><a
                        href="{{ $page['route'] }}">{{ $page['name'] }}</a></li>
            @else
                <li class="breadcrumb-item"><a href="{{ $page['route'] }}">{{ $page['name'] }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>
