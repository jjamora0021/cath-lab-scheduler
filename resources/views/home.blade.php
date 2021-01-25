@extends('layouts.app')

@section('page-css')

@endsection

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

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
                                        <tr class="{{ config('status.bg')[$value->status] }} font-weight-bold">
                                            <td>{{ $value->first_name }} {{ $value->middle_name }} {{ $value->last_name }}</td>
                                            <td>{{ $value->operation }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->date)->format('F d, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->time)->format('h:i A') }}</td>
                                            <td class="text-uppercase">{{ $value->urgency }}</td>
                                            <td>Pending</td>
                                            <td>King Luna</td>
                                            <td>{{ \Carbon\Carbon::parse($value->date)->format('F d,Y') }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Review</button>
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
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Schedule Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group focused">
                                <label class="form-control-label">Patient Name: <h3 id="patient_name" class="mt-2"></h3></label>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group focused">
                                <label class="form-control-label">Age: <h3 id="age" class="mt-2"></h3></label>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group focused">
                                <label class="form-control-label">PT / PTT: <h3 id="pt_ptt" class="mt-2"></h3></label>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group focused">
                                <label class="form-control-label">Weight: <h3 id="weight" class="mt-2">145</h3></label>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group focused">
                                <label class="form-control-label">Height: <h3 id="height" class="mt-2"></h3></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group focused">
                                <label class="form-control-label">Allergies: </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group focused">
                                <label class="form-control-label">Diagnosis: <h3 id="diagnosis" class="mt-2"></h3></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group focused">
                                <label class="form-control-label">Room #: <h3 id="room_number" class="mt-2">123</h3></label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group focused">
                                <label class="form-control-label">Bed #: <h3 id="bed_number" class="mt-2"></h3></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    <script type="text/javascript">
        $('table').DataTable();
    </script>
@endsection

