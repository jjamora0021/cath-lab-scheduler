<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class CalendarController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('calendar');
    }

    public function request()
    {
    	$current_date = Carbon::now()->format("d-m-Y");;
    	return view('request-schedule', compact('current_date'));
    }

    public function createRequestSchedule(Request $request)
    {
    	dd($request->all());
    }
}
