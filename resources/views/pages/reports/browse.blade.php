@extends('layouts.app')

@section('content')
    <div>
        <h2>Reports Dashboard</h2>

        <div class="mb-4" id="order">
            <div class="d-flex flex-row align-items-center justify-content-between my-2">
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

                <h4>Filter</h4>
                <div>
                    <button
                        onclick="location.href='{{ $request->query('filter') != 'handled' ? $request->fullUrlWithQuery(['filter' => 'handled']) : $request->fullUrlWithQuery(['filter' => '']) }}'"
                        type="button" class="{{ $request->query('filter') == 'handled' ? 'active' : '' }} btn btn-custom">
                        <span>Handled</span>
                    </button>
                    <button
                        onclick="location.href='{{ $request->query('filter') != 'notHandled' ? $request->fullUrlWithQuery(['filter' => 'notHandled']) : $request->fullUrlWithQuery(['filter' => '']) }}'"
                        type="button"
                        class="{{ $request->query('filter') == 'notHandled' ? 'active' : '' }} btn btn-custom">
                        <span>Not handled</span>
                    </button>
                </div>
            </div>
        </div>



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
