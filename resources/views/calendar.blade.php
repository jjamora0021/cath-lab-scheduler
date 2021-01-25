@extends('layouts.app')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/fullcalendar.min.css') }}">
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Calendar') }}</h1>

    <div class="row">

        <div class="col-lg-12">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Schedules</h6>
                </div>

                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('page-script')
    <script type="text/javascript" src="{{ asset('js/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/custom-calendar-js.js') }}">
        
    </script>
@endsection
