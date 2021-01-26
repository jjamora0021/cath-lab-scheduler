<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use Session;

use App\Models\PatientInformationModel;
use App\Models\OperationInformationModel;

class CalendarController extends Controller
{
	protected $User;
	protected $PatientInformationModel;

	public function __construct()
    {
        $this->middleware('auth');

        $this->User = new \App\Models\User;
		$this->PatientInformationModel = new \App\Models\PatientInformationModel;
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
    	return view('calendar');
    }

    /**
     * [request description]
     * @return [type] [description]
     */
    public function request()
    {
    	$current_date = Carbon::now()->format("d-m-Y");
    	return view('request-schedule', compact('current_date'));
    }

    /**
     * [createRequestSchedule description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function createRequestSchedule(Request $request)
    {
    	$now = Carbon::now();

    	$date = date('Y-m-d', strtotime($request['date']));
    	$time = Carbon::parse($request['time'])->format('H:i:s');

    	$check = $this->PatientInformationModel->checkSchedule($date, $time);
    	if($check != 0)
    	{
    		return redirect('/request-schedule')
    				->with('failed', 'There is already a procedure booked at that date and time. Please choose another time slot.')
    				->withInput(Input::all());
    	}
    	else 
    	{
    		$data = [
	    		'first_name' => $request['first_name'],
	    		'middle_name' => $request['middle_name'],
	    		'last_name' => $request['last_name'],
	    		'age' => $request['age'],
	    		'pt_ptt' => $request['pt_ptt'],
	    		'weight' => (float)$request['weight'],
	    		'height' => $request['height'],
	    		'room_number' => $request['room_number'],
	    		'bed_number' => $request['bed_number'],
	    		'allergies' => json_encode($request['patient-allergy']),
	    		'diagnosis' => $request['diagnosis'],
	    		'operation' => $request['operation'],
	    		'anesthesiologist' => $request['anesthesiologist'],
	    		'surgeon' => $request['surgeon'],
	    		'date' => $date,
	    		'time' => $time,
	    		'created_at' => $now,
	    		'updated_at' => $now,
	    	];

	    	$save = $this->PatientInformationModel->saveSchedule($data);
	    	if($save)
	    	{
	    		return redirect('/request-schedule')->with('success', 'Schedule successfully saved.');
	    	}
	    	else
	    	{
	    		return redirect('/request-schedule')->with('failed', 'Schedule Failed to be saved.');
	    	}
    	}
    }

    /**
     * [checkSchedule description]
     * @param  [type] $date [description]
     * @param  [type] $time [description]
     * @return [type]       [description]
     */
    public function checkSchedule(Request $request)
    {
    	$date = date('Y-m-d', strtotime($request['date']));
    	$time = Carbon::parse($request['time'])->format('H:i:s');

    	$result = $this->PatientInformationModel->checkSchedule($date, $time);

    	return $result;
    }

    /**
     * [fetchSchedules description]
     * @return [type] [description]
     */
    public function fetchSchedules()
    {
    	$schedules = $this->PatientInformationModel->fetchSchedule();

    	return $schedules;
    }

    /**
     * [fetchScheduleInfo description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function fetchScheduleInfo(Request $request)
    {
        $id = $request['id'];
        $result = $this->PatientInformationModel->fetchScheduleInfo($id);
        
        return $result;
    }
}
