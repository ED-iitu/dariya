<?php

namespace App\Http\Controllers\Admin;

use App\PushSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPanelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('adminPanel.index');
    }

    public function push_settings(){
        $push_settings = PushSetting::all();
        return view('adminPanel.push_settings', ['push_settings' => $push_settings]);
    }
}
