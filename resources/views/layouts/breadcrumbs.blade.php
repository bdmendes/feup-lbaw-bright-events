@section('breadcrumbs')
    <nav class="p-0" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="p-0 m-0 breadcrumb">
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
@endsection
