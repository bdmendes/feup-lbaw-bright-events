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
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <th scope="row">{{ $report->id }}</th>
                                <td>{{ $report->date->diffForHumans() }}</td>
                                <td>{{ $report->report_motive }}</td>
                                <td>{{ $report->handled_by_id ? 'Yes' : 'No' }}</td>
                                <td>
                                    {{ $report->type ?? 'Unknown type' }}
                                </td>
                                <td class="report-toggle" data-bs-toggle="collapse" href="#dets{{ $report->id }}">
                                    <i class="bi bi-chevron-down"></i>
                                </td>
                            </tr>
                            <tr id="dets{{ $report->id }}" class="collapse align-middle">
                                <td id="r{{ $report->id }}" colspan="6">
                                    @include('partials.reports.card', ['report' => $report])
                                </td>
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
        <script type="text/javascript" src={{ asset('js/report.dash.js') }} defer></script>
    </div>
@endsection
