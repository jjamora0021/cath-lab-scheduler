<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Auth;
use Session;
use Config;

class HomeController extends Controller
{
    protected $CalendarController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->CalendarController = new CalendarController();

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $widget = [
            'users' => $users
        ];

        $schedules = $this->CalendarController->fetchSchedules();
        
        return view('home', compact('widget','schedules'));
    }
}
