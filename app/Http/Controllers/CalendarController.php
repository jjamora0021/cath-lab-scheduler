<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

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
                'urgency' => $request['urgency'],
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
     * [fetchcheduleForCalendar description]
     * @return [type] [description]
     */
    public function fetchcheduleForCalendar()
    {
        $data = $this->PatientInformationModel->fetchSchedule();
        $schedules = array();
        foreach ($data as $key => $value) {
            $schedules[$key]['title'] = $value->operation . ' - ' . $value->first_name . ' ' . $value->middle_name . ' ' . $value->last_name;
            $schedules[$key]['start'] = $value->date . 'T' . $value->time;
        }
        
        $holidays = $this->fetchHolidays();
        $schedules = array_merge($schedules,$holidays);

        return json_encode($schedules);
    }

    /**
     * [fetchHolidays description]
     * @return [type] [description]
     */
    public function fetchHolidays()
    {
        $google_api_key = 'AIzaSyBJNl1Z2Xz2kx4vl_Kyvo2tkpCF0Ci45KU';
        $json = file_get_contents('https://www.googleapis.com/calendar/v3/calendars/en.philippines%23holiday%40group.v.calendar.google.com/events?key='.$google_api_key);
        $json_decode = json_decode($json, true)['items'];
        

        $holidays = array();
        foreach ($json_decode as $key => $value) {
            $data_date = explode('-', $value['start']['date'])[0];
            if($data_date == date('Y'))
            {
                $holidays[$key]['title'] = $value['summary'];
                $holidays[$key]['date'] = $value['start']['date'];
                $holidays[$key]['display'] = 'background';
                $holidays[$key]['color'] = '#ff9f89';
            }
        }

        return $holidays;
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

    /**
     * [updateScheduleInfo description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateScheduleInfo(Request $request)
    {
        $user_data = Auth::user();
        $id = $request['id'];
        $approval = $request['approval'];
        $date = date('Y-m-d', strtotime($request['date']));
        $time = Carbon::parse($request['time'])->format('H:i:s');

        $result = $this->PatientInformationModel->updateScheduleInfo($id, $approval, $date, $time, $user_data);

        return $result;
    }
}
