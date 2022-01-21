<div class="pb-3">

    <h3 class="pb-4">Search</h3>
    <form action="{{ route('browseEvents') }}" method="GET" class="mb-0">
        <div class="d-flex flex-nowrap">
            <input type="text" name="global" value="{{ $request->global ?? '' }}" autocomplete="off" name="search"
                class="input" placeholder="Enter a keyword">
            <span>
                <button class="btn btn-outline-light" style="border:none; " type="submit">
                    <i class="bi bi-search" style="color: black;"></i>
                </button>
            </span>
        </div>
    </form>
</div>


<div class="d-flex w-100 justify-content-between align-items-center mb-3" data-bs-toggle="collapse" href="#filter">
    <h2>Filter</h2>
    <i class="bi bi-chevron-down"></i>
</div>

<div class="pb-4 collapse {{ $request->filled('begin_date') || $request->filled('end_date') || $request->filled('organizer') || $request->filled('tag') ? 'show' : '' }}"
    id="filter">
    <form method="GET">
        <div class="d-flex w-100 justify-content-between" data-bs-toggle="collapse" href="#filter-date"
            onclick="flip('flip-date');" id="flip-date">
            <h4>Date</h4>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="collapse {{ $request->filled('begin_date') || $request->filled('end_date') ? 'show' : '' }}"
            id="filter-date">

            <div class="d-flex justify-content-between align-items-center py-2">
                <h5>Begin</h5>
                <input class="input" id="date" value="{{ $request->begin_date }}" type="date"
                    name="begin_date" onchange="this.form.submit()">
            </div>
            <div class="d-flex justify-content-between align-items-center py-2">
                <h5>End</h5>
                <input class="input" id="date" value="{{ $request->end_date }}" type="date" name="end_date"
                    onchange="this.form.submit()">
            </div>

        </div>

        <div data-bs-toggle="collapse" href="#filter-organizer">
            <div class="d-flex w-100 justify-content-between" data-bs-toggle="collapse" href="#filter-organizer">
                <h4>Organizer</h4>
                <i class="bi bi-chevron-down"></i>
            </div>
        </div>
        <div class="collapse {{ $request->filled('organizer') ? 'show' : '' }}" id="filter-organizer">

            <input type="search" autocomplete="off" name="organizer" onchange="this.form.submit()"
                value="{{ $request->filled('organizer') ? $request->query('organizer') : '' }}">


        </div>

        <div data-bs-toggle="collapse" href="#filter-tag">
            <div class="d-flex w-100 justify-content-between" data-bs-toggle="collapse" href="#filter-tag">
                <h4>Tag</h4>
                <i class="bi bi-chevron-down"></i>
            </div>
        </div>
        <div class="pb-4 collapse {{ $request->filled('tag') ? 'show' : '' }}" id="filter-tag">

            <input type="search" autocomplete="off" name="tag" onchange="this.form.submit()"
                value="{{ $request->filled('tag') ? $request->query('tag') : '' }}">

        </div>
    </form>
</div>

<div class="d-flex w-100 justify-content-between align-items-center mb-3" data-bs-toggle="collapse" href="#order">
    <h2>Order By</h2>
    <i class="bi bi-chevron-down"></i>
</div>

<div class="mb-4 collapse {{ $request->filled('sort_by') ? 'show' : '' }}" id="order">
    <div class="d-flex align-items-center justify-content-between">
        <h4>Title</h4>
        <div>
            <button
                onclick="location.href='{{ $request->fullUrlWithQuery(['sort_by' => 'title', 'order' => 'ascending']) }}'"
                type="button"
                class="{{ $request->query('sort_by') == 'title' && $request->query('order') == 'ascending' ? 'active' : '' }}  btn btn-custom">
                <i class="bi bi-arrow-up" style="color: white;"></i>
            </button>
            <button
                onclick="location.href='{{ $request->fullUrlWithQuery(['sort_by' => 'title', 'order' => 'descending']) }}'"
                type="button"
                class="{{ $request->query('sort_by') == 'title' && $request->query('order') == 'descending' ? 'active' : '' }} btn btn-custom">
                <i class="bi bi-arrow-down" style="color: white;"></i>
            </button>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between my-2">
        <h4>Date</h4>
        <div>
            <button
                onclick="location.href='{{ $request->fullUrlWithQuery(['sort_by' => 'date', 'order' => 'ascending']) }}'"
                type="button"
                class="{{ $request->query('sort_by') == 'date' && $request->query('order') == 'ascending' ? 'active' : '' }} btn btn-custom">
                <i class="bi bi-arrow-up" style="color: white;"></i>
            </button>
            <button
                onclick="location.href='{{ $request->fullUrlWithQuery(['sort_by' => 'date', 'order' => 'descending']) }}'"
                type="button"
                class="{{ $request->query('sort_by') == 'date' && $request->query('order') == 'descending' ? 'active' : '' }} btn btn-custom">
                <i class="bi bi-arrow-down" style="color: white;"></i>
            </button>
        </div>
    </div>
</div>
