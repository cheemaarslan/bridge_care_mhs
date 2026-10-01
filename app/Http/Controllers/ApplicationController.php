<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PracticeApplication;
use App\Models\CoordinatorApplication;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coordinator_applications = CoordinatorApplication::where('status', 0)->latest()->get();
        $practice_applications = PracticeApplication::where('status', 0)->latest()->get();
        // dd($practice_application);
        return view('application.index' , compact('practice_applications','coordinator_applications'));
    }

   
}
