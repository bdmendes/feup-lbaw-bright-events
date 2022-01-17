@extends('layouts.app')

@section('content')

    <div>
        <h2>Reports Dashboard</h2>
        <div class="mt-4">
            @if (!$reports->isEmpty())
                <table class="table" id="reports">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Date</th>
                            <th scope="col">Motive</th>
                            <th scope="col">Handled</th>
                            <th scope="col">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr data-bs-toggle="collapse" href="#r{{ $report->id }}">
                                <th scope="row">{{ $report->id }}</th>
                                <td>{{ $report->date->diffForHumans() }}</td>
                                <td>{{ $report->report_motive }}</td>
                                <td>{{ $report->handled_by_id ? 'Yes' : 'No' }}</td>
                                @if (isset($report->reported_comment_id))
                                    <td>Comment</td>
                                @endif
                                @if (isset($report->reported_event_id))
                                    <td>Event</td>
                                @endif
                                @if (isset($report->reported_user_id))
                                    <td>User</td>
                                @endif
                            </tr>
                            <tr data-bs-toggle="collapse" class="collapse border border-1" id="r{{ $report->id }}">
                                <td colspan="5">PEEEENISSSSS</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3>No reports to show</h3>
            @endif
            @if ($reports->links()->paginator->hasPages())
                <div class="mt-4">
                    {!! $reports->links() !!}
                </div>
            @endif
        </div>
    </div>
@endsection
