<tr>
    <th scope="row">{{ $report->id }}</th>
    <td>{{ $report->date->diffForHumans() }}</td>
    <td>{{ $report->report_motive }}</td>
    <td>{{ $report->handled_by_id ? 'Yes' : 'No' }}</td>
    <td>
        {{ $report->type ?? 'Unknown type' }}
    </td>
    <td class="report-toggle" data-bs-toggle="collapse" href="#dets{{ $report->id }}">
        <i class="bi bi-chevron-compact-down"></i>
    </td>
</tr>
<tr id="dets{{ $report->id }}" class="collapse align-middle">
    <td colspan="6">
        <div class="text-dark card border">
            <div class="row gap-0">
                <div class="card-body">
                    <h3 class="card-title">Report details</h3>
                    <div class="card-text d-flex flex-row">
                        <div class="me-5">
                            <h4>Date</h4>
                            <p>{{ $report->date }}</p>
                        </div>
                        <div>
                            <h4>Description</h4>
                            <p>{{ $report->description }}</p>
                        </div>
                        @if (isset($report->handled_by_id))
                            <div>
                                <h4>Handled By</h4>
                                <p>{{ $report->handled_by_id }}</p>
                            </div>
                        @endif
                        <div class="ms-auto pe-5">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success mark-handled-action"
                                    value="{{ $report->id }}">Mark as
                                    handled</button>
                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    @if ($report->type != 'comment')
                                        <li value="{{ $report->id }}" class="dropdown-item block-action">Block
                                        </li>
                                    @endif
                                    @if ($report->type != 'event')
                                        <li value="{{ $report->id }}" class="dropdown-item delete-action">Delete
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="px-1">
                        @if ($report->type == 'user')
                            @include('partials.users.smallCard', ['user' => $report->reportedUser])
                        @else
                            @if ($report->type == 'event')

                                @include('partials.events.card', ['event' => $report->reportedEvent])
                            @else
                                @if ($report->type == 'comment')
                                    @if (isset($report->reportedComment))
                                        @include('partials.events.comment', ['comment' => $report->reportedComment,
                                        'is_report'
                                        =>
                                        true])
                                    @else
                                        Comment already deleted.
                                    @endif
                                @else
                                    Unrecognized Type
                                @endif

                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
