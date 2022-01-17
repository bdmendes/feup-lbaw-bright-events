<div class="container">
    <div class="row border-bottom border-1 row-bg">
        <div class="col-1 fw-bolder fs-4">Id</div>
        <div class="col fw-bolder fs-4">Motive</div>
        <div class="col fw-bolder fs-4">Date</div>
        <div class="col fw-bolder fs-4">Handled</div>
        <div class="col fw-bolder fs-4">Type</div>
        <div class="col-1 fw-bolder fs-4"></div>
    </div>
    @foreach ($reports as $report)
        <div class="row">
            <div class="col-1">{{ $report->id }} </div>
            <div class="col">{{ $report->report_motive }} </div>
            <div class="col">{{ $report->date->diffForHumans() }} </div>
            <div class="col">
                @if ($report->handled_by_id)
                    Yes
                @else
                    No
                @endif
            </div>
            @if ($report->reported_comment_id)
                <?php $type = 'Comment';
                $id = $report->reported_comment_id; ?>
                <div class="col"> Comment </div>
            @else
                @if ($report->reported_event_id)
                    <?php $type = 'Event';
                    $id = $report->reported_event_id; ?>
                    <div class="col"> Event </div>
                @else
                    <?php $type = 'User';
                    $id = $report->reported_user_id; ?>
                    <div class="col"> User </div>
                @endif
            @endif
            <div role="button" class="col-1">
                <div data-bs-toggle="collapse" href="#r{{ $report->id }}"><i class="bi bi-chevron-down"></i></a>
                </div>
            </div>
        </div>
        <div class="row collapse border border-1" id="r{{ $report->id }}">
            <div class="mb-4 mt-4">
                <h3>Date</h3>
                <p>{{ $report->date->toDateTimeString() }}</p>
                <h3>Description</h3>
                <p>{{ $report->description }}</p>
                <h3>ID</h3>
                <p>{{ $type }} {{ $id }}</p>
                @if ($report->handled_by_id)
                    <h3>Handler</h3>
                    <p>{{ $report->handled_by_id }}</p>
                @else

                @endif
            </div>
        </div>
    @endforeach
</div>
