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

                    @foreach ($reports as $report)
                        <tbody id="r{{ $report->id }}">
                            @include('partials.reports.card', ['report' => $report])
                        </tbody>
                    @endforeach

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
