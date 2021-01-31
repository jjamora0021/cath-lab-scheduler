@extends('layouts.app')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Request Schedule') }}</h1>

    <div class="row">

        <div class="col-md-10 offset-md-1">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('failed'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Schedule Information</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('create-request-schedule') }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="_method" value="POST">

                        {{-- Patient Information --}}
                        <div class="col-lg-12" id="patient-information">
                            <h6 class="heading-small text-muted mb-4">Patient information</h6>

                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="first_name">First Name<span class="small text-danger"> *</span></label>
                                            <input type="text" id="first_name" class="form-control" name="first_name" placeholder="First Name" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="middle_name">Middle Name<span class="small text-danger"> (Optional)</span></label>
                                            <input type="text" id="middle_name" class="form-control" name="middle_name" placeholder="Middle Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="last_name">Last Name<span class="small text-danger"> *</span></label>
                                            <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last name" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="age">Age<span class="small text-danger"> *</span></label>
                                            <input type="number" id="age" class="form-control" name="age" placeholder="0" min="0" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="pt_ptt">PT / PTT<span class="small text-danger"> *</span></label>
                                            <input type="number" id="pt_ptt" class="form-control" name="pt_ptt" placeholder="0" min="0" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="weight">Weight in kg<span class="small text-danger"> *</span></label>
                                            <input type="text" id="weight" class="form-control" name="weight" placeholder="0" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="height">Height<span class="small text-danger"> *</span></label>
                                            <input type="text" id="height" class="form-control" name="height" placeholder="5'6" min="0" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="room_number">Room #<span class="small text-danger"> *</span></label>
                                            <input type="text" id="room_number" class="form-control" name="room_number" placeholder="Room #" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="bed_number">Bed #<span class="small text-danger"> *</span></label>
                                            <input type="text" id="bed_number" class="form-control" name="bed_number" placeholder="Bed #" required="true">
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="col-lg-4 offset-lg-4">
                                    <div class="row">
                                        <div class="col text-center">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="allergies">Allergies</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Add Patient Allergy" id="allergies">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button" onclick="requestScheduleFunctions.addAllergies();">Add Allergies</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-lg-8 offset-lg-2">
                                        <input type="hidden" value="0" id="allergy-count">
                                        <ul class="list-group align-middle" id="allergies"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="col-lg-12 mt-3" id="operation-information">
                            <h6 class="heading-small text-muted mb-4">Operation information</h6>

                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="diagnosis">Diagnosis<span class="small text-danger"> *</span></label>
                                            <input type="text" id="diagnosis" class="form-control" name="diagnosis" placeholder="Diagnosis" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="operation">Operation<span class="small text-danger"> *</span></label>
                                            <input type="text" id="operation" class="form-control" name="operation" placeholder="Operation" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="urgency">Urgency<span class="small text-danger"> *</span></label>
                                            <select class="form-control selectpicker" id="urgency" required="true" name="urgency" data-style="btn-primary" title="Select Urgency">
                                                <option value="elective">Elective</option>
                                                <option value="emergency">Emergency</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="anesthesiologist">Anesthesiologist<span class="small text-danger"> *</span></label>
                                            <input type="text" id="anesthesiologist" class="form-control" name="anesthesiologist" placeholder="Anesthesiologist" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="surgeon">Surgeon<span class="small text-danger"> *</span></label>
                                            <input type="text" id="surgeon" class="form-control" name="surgeon" placeholder="Surgeon" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="date">Date<span class="small text-danger"> *</span></label>
                                            <input type="text" id="date" class="form-control" name="date" placeholder="{{ $current_date }}" required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="time">Time<span class="small text-danger"> *</span></label>
                                            <input type="text" id="time" class="form-control" name="time" placeholder="08:00 AM" required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Button -->
                        <div class="pl-lg-4 pt-3 pb-3">
                            <div class="row">
                                <div class="col text-center">
                                    <button id="save-schedule" type="submit" class="btn btn-success" disabled>Save</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>

    @include('includes.schedule-validator-modal')
@endsection

@section('page-script')
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/custom-date-time-picker-js.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function($) {
            dateTimePickerFunctions.onLoad();
            $('.selectpicker').selectpicker();
            $('#time').datetimepicker().on("dp.change",function() {
                requestScheduleFunctions.checkSchedule($('#date').val(), $('#time').val());
            });
        });
    </script>
@endsection