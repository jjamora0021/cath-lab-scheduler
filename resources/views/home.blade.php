@extends('layouts.app')

@section('page-css')

@endsection

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h4 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- Schedules Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Schedules</h6>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <th>Patient Name</th>
                                <th>Operation</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Urgency</th>
                                <th>Status</th>
                                <th>Approved By</th>
                                <th>Date Approved</th>
                                <th></th>
                            </thead>
                            @if(empty($schedules))
                                <tbody></tbody>    
                            @else
                                <tbody>
                                    @foreach($schedules as $key => $value)
                                        <tr class="text-{{ config('status.bg')[$value->status] }} font-weight-bold">
                                            <td>{{ $value->first_name }} {{ $value->middle_name }} {{ $value->last_name }}</td>
                                            <td>{{ $value->operation }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->date)->format('F d, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->time)->format('h:i A') }}</td>
                                            <td class="text-capitalize">{{ $value->urgency }}</td>
                                            <td class="text-capitalize">{{ $value->status }}</td>
                                            <td>{{ $value->approved_by != NULL ? $value->approved_by : '' }}</td>
                                            <td>{{ $value->date_approved != NULL ? \Carbon\Carbon::parse($value->date_approved)->format('F d,Y') : '' }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary" onclick="requestScheduleFunctions.fetchSchedule({{ $value->id }});">Review</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true" id="schedule-info-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Schedule Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="alert alert-success d-none" role="alert" id="alert-success">
                            Schedule has been Successfully <span class="text-uppercase" id="changed-status"></span>
                        </div>
                        <div class="alert alert-danger d-none" role="alert" id="alert-danger">
                            Something went wrong. Please try again.
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label">Patient Name: <h4 id="patient_name" class="mt-2"></h4></label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group focused">
                                    <label class="form-control-label">Age: <h4 id="age" class="mt-2"></h4></label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group focused">
                                    <label class="form-control-label">PT / PTT: <h4 id="pt_ptt" class="mt-2"></h4></label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group focused">
                                    <label class="form-control-label">Weight in kg: <h4 id="weight" class="mt-2"></h4></label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group focused">
                                    <label class="form-control-label">Height: <h4 id="height" class="mt-2"></h4></label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group focused">
                                    <label class="form-control-label">Allergies: </label>
                                    <ul class="list-group" id="allergies-list">
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group focused">
                                    <label class="form-control-label">Room #: <h4 id="room_number" class="mt-2"></h4></label>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group focused">
                                    <label class="form-control-label">Bed #: <h4 id="bed_number" class="mt-2"></h4></label>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group focused">
                                    <label class="form-control-label">Diagnosis: <h4 id="diagnosis" class="mt-2"></h4></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label">Operation: <h4 id="operation" class="mt-2"></h4></label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label">Surgeon: <h4 id="surgeon" class="mt-2"></h4></label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label">Anesthesiologist: <h4 id="anesthesiologist" class="mt-2"></h4></label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group focused">
                                    <label class="form-control-label text-capitalize">Urgency: <h4 id="urgency" class="mt-2"></h4></label>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group focused">
                                    <label class="form-control-label text-capitalize">Status: <h4 id="status" class="mt-2 text-{{ config('status.bg')[$value->status] }} font-weight-bold"></h4></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-block">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-success" onclick="requestScheduleFunctions.updateSchedule({{ $value->id }}, '{{ $value->status }}', 'approved');">Approve</button>
                            <button type="button" class="btn btn-danger" onclick="requestScheduleFunctions.updateSchedule({{ $value->id }}, '{{ $value->status }}', 'decline');">Decline</button>
                        </div>
                        <div class="col-lg-6 text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close-btn">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    <script type="text/javascript" src="{{ asset('js/custom-request-schedule-js.js') }}"></script>
    <script type="text/javascript">
        $('table').DataTable();
    </script>
@endsection

