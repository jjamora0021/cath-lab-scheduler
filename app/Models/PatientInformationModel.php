<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PatientInformationModel extends Model
{
    use HasFactory;

    /**
     * [saveSchedule description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function saveSchedule($data)
    {
    	$save = DB::table('patient_info')->insert($data);

    	return $save;
    }

    /**
     * [checkSchedule description]
     * @param  [type] $date [description]
     * @param  [type] $time [description]
     * @return [type]       [description]
     */
    public function checkSchedule($date, $time)
    {
    	$check = (DB::table('patient_info')
    				->where('date', $date)
    				->where('time', $time)
    				->get())->count();

    	return $check;
    }

    /**
     * [fetchSchedule description]
     * @return [type] [description]
     */
    public function fetchSchedule()
    {
    	$schedules = (DB::table('patient_info')->get())->toArray();

    	return $schedules;
    }

    /**
     * [fetchScheduleInfo description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function fetchScheduleInfo($id)
    {
    	$data = (DB::table('patient_info')->where('id',$id)->get())->toArray();
    	
    	return $data;
    }
}
