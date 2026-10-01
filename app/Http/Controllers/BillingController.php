<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Practice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function rpm_billing_index()
    {
        $start_of_month = Carbon::now()->startOfMonth()->format('m-d-Y');

        return view('billing.rpm.index', compact('start_of_month'));
    }
    public function rpm_billing_filter(Request $request)
    {
        Log::info($request->all());
        $start_date = set_format($request->start_date);
        $end_date = set_format($request->end_date);
        $billing = null;
        if($start_date && $end_date){
            $billing = Patient::with('care_manager','doctor','device')
                ->with(['phone_call' => function($query) use($start_date, $end_date){
                    $query->whereBetween('date', [$start_date, $end_date]);
                }])
                ->with(['days_with_reading' => function($query) use($start_date, $end_date){
                    $query->select('patient_id', 'date_time', 'data',DB::raw('Date(date_time) as date'));
                    $query->whereBetween('date_time', [$start_date." 00:00:00", $end_date." 23:59:59"]);
                    $query->groupBy('patient_id','date');
                }])
                ->with(['rpm_codes' => function($query) use($start_date, $end_date){
                    $query->select('patient_id','code', 'created_at');
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                    $query->groupBy('patient_id','code');
                }])
                ->withSum(['rpm_codes' => function($query) use($start_date, $end_date){
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                }], 'minutes')
                ->withSum(['rpm_codes' => function($query) use($start_date, $end_date){
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                }], 'seconds')
                ->where('enrol_in_rpm', true)
                ->where('practice_id', auth()->user()->practice_id)
                ->where('status', 1)->orderBy('first_name','asc')->get();

            return response($billing);
        }

    }

    public function ccm_billing_index()
    {
        $doctor = User::whereHas('roles', function($query){
            $query->where('name', 'doctor');
        })->first();
        $practice = Practice::first();
        $start_of_month = Carbon::now()->format('M-Y');

        return view('billing.ccm.index', compact('start_of_month', 'doctor', 'practice'));
    }
    public function ccm_billing_filter(Request $request)
    {
        $billing = null;
        if($request->has('start_date') && $request->has('end_date')){
            $start_date = set_format($request->start_date);
            $end_date = set_format($request->end_date);

            $billing = Patient::with('insurance','chronic_conditions','care_plan', 'monthly_review', 'latest_ccm_code')->with(['ccm_codes' => function($query) use($start_date, $end_date){
                $query->select('patient_id','code', 'created_at');
                $query->groupBy('patient_id','code');
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }])->where('enrol_in_ccm', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('status', 1)->orderBy('first_name','asc')->get();
        }
        else{
            $month = Carbon::createFromFormat('M-Y', $request->month_date)->format('m');
            $year = Carbon::createFromFormat('M-Y', $request->month_date)->format('Y');

            $billing = Patient::with('insurance','chronic_conditions','care_plan', 'monthly_review', 'latest_ccm_code')
            ->with(['ccm_codes' => function($query) use($month, $year){
                $query->select('patient_id','code', 'created_at');
                $query->groupBy('patient_id','code');
                $query->whereMonth('created_at', $month);
                $query->whereYear('created_at', $year);
            }])
            ->where('enrol_in_ccm', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('status', 1)->orderBy('first_name','asc')->get();
        }
        return response($billing);

    }
}
