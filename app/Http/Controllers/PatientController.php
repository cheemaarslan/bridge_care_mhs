<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Device;
use App\Models\MyNotes;
use App\Models\Patient;
use App\Models\Setting;
use App\Models\Practice;
use App\Models\Insurance;
use Illuminate\Http\Request;
use App\Models\CarePlanScheme;
use App\Models\ActivityLog;
use App\Models\ChronicCondition;
use Illuminate\Support\Facades\DB;
use App\Models\MonthlyReviewScheme;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['permission:view_all_patient'])->only('index');
        $this->middleware(['permission:create_patient'])->only('create', 'store');
        $this->middleware(['permission:update_patient'])->only('update', 'edit');
        $this->middleware(['permission:delete_patient'])->only('destroy');
    }
    public function index()
    {
        $rpm_record_from = Setting::search('rpm_record_from');

        $to = Carbon::now()->toDateString();
        $from = Carbon::now()->subMonth()->toDateString();

        if ($rpm_record_from) {
            $from = $rpm_record_from;
        }

        $all_care_plan = Patient::whereHas('care_plan', function ($query) {
            $query->where('active', true);
        })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->count();
        $remaining_care_plan = Patient::WhereDoesntHave('care_plan', function ($query) {
            $query->where('active', true);
        })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->count();
        $less_than_care_plan = Patient::whereHas('care_plan', function ($query) {
            $query->where('active', true);
            $query->where('minutes', '<', 10);
        })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->count();
        $greater_than_care_plan = Patient::whereHas('care_plan', function ($query) {
            $query->where('active', true);
            $query->where('minutes', '>=', 10);
        })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->count();


        $all_monthly_review = Patient::whereHas('monthly_review', function ($query) {
            $query->where('active', true);
        })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->count();
        $remaining_monthly_review = Patient::WhereDoesntHave('monthly_review', function ($query) {
            $query->where('active', true);
        })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->count();
        $less_than_monthly_review = Patient::whereHas('monthly_review', function ($query) {
            $query->where('active', true);
            $query->where('minutes', '<', 10);
        })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->count();
        $greater_than_monthly_review = Patient::whereHas('monthly_review', function ($query) {
            $query->where('active', true);
            $query->where('minutes', '>', 10);
        })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->count();




        $ccm_patients = null;
        $rpm_patients = null;
        $unenrolled_patients = null;

        $ccm_patients = Patient::with('care_manager', 'care_plan')
            ->withSum(['time_tracks' => function ($query) {
                $query->whereMonth('engagement_date', Carbon::now()->month);
            }], 'minutes')->withSum(['time_tracks' => function ($query) {
                $query->whereMonth('engagement_date', Carbon::now()->month);
            }], 'seconds')
            ->where('enrol_in_ccm', true)->where('status', true)
            ->orderBy('first_name', 'asc')->get();

        $rpm_patients = Patient::with(['last_patient_data', 'care_manager', 'doctor'])
            ->with(['phone_call' => function ($query) use ($to, $from) {
                $query->whereBetween('date', [$from, $to]);
            }])
            ->with(['days_with_reading' => function ($query) use ($to, $from) {
                $query->select('patient_id', DB::raw('Date(date_time) as date'));
                $query->whereBetween('date_time', [$from, $to]);
                $query->groupBy('patient_id', 'date');
            }])
            ->withSum(['time_tracks' => function ($query) use ($to, $from) {
                $query->whereBetween('engagement_date', [$from, $to]);
            }], 'minutes')->withSum(['time_tracks' => function ($query) use ($to, $from) {
                $query->whereBetween('engagement_date', [$from, $to]);
            }], 'seconds')
            ->withAvg('patient_data', 'data->pul')
            ->withAvg('patient_data', 'data->sys')
            ->withAvg('patient_data', 'data->dia')
            ->where('enrol_in_rpm', true)
            ->where('status', true)->orderBy('first_name', 'asc')->get();

        $lastUpdated = Patient::latest('updated_at')->value('updated_at');

        $unenrolled_patients = Patient::where('status', false)->get();

        $ccm_patient_count = $ccm_patients->count();
        $rpm_patient_count = $rpm_patients->count();
        $total_patient = $ccm_patient_count + $rpm_patient_count;

        $simple = $ccm_patients->where('ccm_type', 'Simple')->count();
        $complex = $ccm_patients->where('ccm_type', 'Complex')->count();

        // $rpm = session('rpm', false);
        // $unenrolled = session('unenrolled', false);
        // if ($rpm || $unenrolled) {
        //     $ccm = session('ccm', false);
        // } else {
        //     $ccm = session('rpm', true);
        // }
        
        $rpm        = session('rpm', true);   // ← default TRUE (show RPM first)
        $ccm        = session('ccm', false);  // ← default false
        $unenrolled = session('unenrolled', false);


        $select_category_rpm = session('select_category_rpm', 'None');
        $select_status_rpm = session('select_status_rpm', 'None');
        $select_time_taken_rpm = session('select_time_taken_rpm', 'None');
        $select_last_checked_rpm = session('select_last_checked_rpm', 'None');


        $select_covid_status_ccm = session('select_covid_status_ccm', 'None');
        $select_gender_ccm = session('select_gender_ccm', 'None');
        $select_last_ccm_performed = session('select_last_ccm_performed', 'None');
        $select_minutes_rpm = session('select_minutes_rpm', 'None');
        $select_days_with_reading_rpm = session('select_days_with_reading_rpm', 'None');

        $total         = $rpm_patients->count();

        // === CORRECT CALCULATIONS (using your existing get_category logic) ===
        $noData         = 0;
        $summaryNormal  = 0;
        $summaryS1      = 0;
        $summaryS2      = 0;
        $summaryCrisis  = 0;

        $statusNormal   = 0;
        $statusS1       = 0;
        $statusS2       = 0;
        $statusCrisis   = 0;

        $callsDone = 0;

        $aboveGoal = 0;
        $nearGoal  = 0;
        $belowGoal = 0;

        $totalMins = 0;
        $noMins = 0;

        foreach ($rpm_patients as $p) {
            // No Data
            if (!$p->last_patient_data) {
                $noData++;
                continue;
            }

            // Avg BP Category (using your get_category function)
            $avg_sys = floor($p->patient_data_avg_datasys ?? 0);
            $avg_dia = floor($p->patient_data_avg_datadia ?? 0);
            $category = get_category($avg_sys, $avg_dia);

            if ($category === 'Normal') $summaryNormal++;
            elseif ($category === 'Stage-1') $summaryS1++;
            elseif ($category === 'Stage-2') $summaryS2++;
            elseif ($category === 'Crisis') $summaryCrisis++;

            // Last BP Status
            $status = $p->last_patient_data->category ?? 'Normal';
            if ($status === 'Normal') $statusNormal++;
            elseif ($status === 'Stage-1') $statusS1++;
            elseif ($status === 'Stage-2') $statusS2++;
            elseif ($status === 'Crisis') $statusCrisis++;

            // Calls
            if ($p->phone_call) $callsDone++;

            // Minutes tracking
            $mins = $p->time_tracks_sum_minutes ?? 0;
            $totalMins += $mins;
            if ($mins >= 20)     $aboveGoal++;
            elseif ($mins >= 12) $nearGoal++;
            elseif ($mins > 0)   $belowGoal++;
            else                 $noMins++;
        }

        $withData = $total - $noData;

        $avgDays = $total > 0
            ? round($rpm_patients->sum(fn($p) => $p->days_with_reading->count()) / $total, 1)
            : 0;

        return view('patient.index', compact(
            'to',
            'from',
            'ccm_patients',
            'rpm_patients',
            'total',
            'lastUpdated',
            'unenrolled_patients',
            'simple',
            'complex',
            'ccm_patient_count',
            'rpm_patient_count',
            'total_patient',
            'all_care_plan',
            'remaining_care_plan',
            'less_than_care_plan',
            'greater_than_care_plan',
            'all_monthly_review',
            'remaining_monthly_review',
            'less_than_monthly_review',
            'greater_than_monthly_review',
            'ccm',
            'rpm',
            'unenrolled',
            'select_covid_status_ccm',
            'select_gender_ccm',
            'select_last_ccm_performed',
            'select_category_rpm',
            'select_status_rpm',
            'select_time_taken_rpm',
            'select_last_checked_rpm',
            'select_minutes_rpm',
            'select_days_with_reading_rpm',
            'noData',
            'summaryNormal',
            'summaryS1',
            'summaryS2',
            'summaryCrisis',
            'statusNormal',
            'statusS1',
            'statusS2',
            'statusCrisis',
            'callsDone',
            'withData',
            'aboveGoal',
            'nearGoal',
            'belowGoal',
            'totalMins',
            'avgDays',
            'noMins'
        ));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chronic_conditions = ChronicCondition::all();
        $insurances = Insurance::all();
        $practices = Practice::all();
        $devices = Device::doesntHave('patient')->get();
        $setting = Setting::first();
        $doctor = null;
        if (!auth()->user()->practice_id) {
            $doctor = User::whereHas('roles', function ($query) {
                $query->where('name', 'doctor');
            })->where('practice_id', 1)->first('user_name');
        } else {
            $doctor = User::whereHas('roles', function ($query) {
                $query->where('name', 'doctor');
            })->where('practice_id', Auth::user()->practice_id)->first('user_name');
        }


        return view('patient.create', compact('chronic_conditions', 'insurances', 'devices', 'practices', 'setting', 'doctor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:1', 'max:255'],
            'last_name' => ['required', 'string', 'min:1', 'max:255'],
            'patient_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4048'],
            'email' => ['required_if:enrol_in_ccm,1', 'email'],
            'dob' => ['required'],
            'contact_no' => ['nullable'],
            'age' => ['required', 'integer', 'min:1', 'max:150'],
            'gender' => ['required'],
            'address' => ['nullable'],

            'chronic_condition_id' => ['required', 'array', 'min:1'],
            'practice_id' => ['required'],
            'care_manager_id' => ['required'],
            'doctor_id' => ['required'],
            'enrol_in_ccm' => ['nullable'],
            'enrol_in_rpm' => ['required'],
            'insurance_id' => ['nullable'],
            'policy_no' => ['nullable'],
            'ccm_enrol_date' => ['required_if:enrol_in_ccm,1'],
            'ccm_type' => ['required_if:enrol_in_ccm,1'],
            'rpm_enrol_date' => ['required_if:enrol_in_rpm,1'],
            'consent' => ['nullable'],

            'preferred_time' => ['required'],
            'preferred_communication' => ['required'],
            'preferred_language' => ['required'],

        ]);

        $patient  = new Patient();
        $data['patient_id'] = $patient->unique_code();
        $data['slug'] = $patient->slug($request->first_name);

        $patient = Patient::create($data);
        if ($request->enrol_in_rpm == "1") {
            Device::where('id', $request->device_id)->update(['patient_id' => $patient->id]);
        }
        if ($request->chronic_condition_id) {
            $patient->chronic_conditions()->attach($request->chronic_condition_id);
        }
        $subject = 'Created Patient';
        $description = 'Patient ' . $patient->first_name . ' ' . $patient->last_name . ' has been created.';
        $this->logActivity($subject, $description, Patient::class, $patient->id);
        return redirect()->route('home')->with('status', 'A new patient has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient, $type = "ccm")
    {
        // dd($patient, $type);
        // if($patient->status){
        $from = Carbon::now()->startOfMonth()->format('m-d-Y');
        $care_plan_schemes = CarePlanScheme::all();
        $monthly_review_schemes = MonthlyReviewScheme::all();
        $engagement_types = Setting::first()->pluck('engagement_types')->first();
        $devices = Device::all();
        $patient_notes = MyNotes::where('patient_id', $patient->id)->get();
        return view('patient.show', compact('patient', 'patient_notes', 'care_plan_schemes', 'monthly_review_schemes', 'devices', 'engagement_types', 'from', 'type'));

        // }
        // else{
        //     abort(403, 'Please Enrol this patient');
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        $chronic_conditions  = ChronicCondition::all();
        $care_managers = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'care-manager');
            }
        )->get();
        $doctors = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'doctor');
            }
        )->get();
        $practices = Practice::all();

        $insurances = Insurance::all();
        $devices = Device::doesntHave('patient')->get();
        $languages = Setting::first()->pluck('languages')->first();

        return view('patient.edit', compact('patient', 'care_managers', 'doctors', 'chronic_conditions', 'insurances', 'devices', 'practices', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        // dd($request);
        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:1', 'max:255'],
            'last_name' => ['required', 'string', 'min:1', 'max:255'],
            'patient_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4048'],
            'email' => ['required_if:enrol_in_ccm,1', 'email'],
            'dob' => ['required'],
            'contact_no' => ['nullable'],
            'age' => ['required', 'integer', 'min:1', 'max:150'],
            'gender' => ['required'],
            'address' => ['nullable'],

            'chronic_condition_id' => ['required', 'array', 'min:1'],
            'practice_id' => ['required'],
            'care_manager_id' => ['required'],
            'doctor_id' => ['required'],
            'enrol_in_ccm' => ['nullable'],
            'enrol_in_rpm' => ['required'],
            'insurance_id' => ['nullable'],
            'policy_no' => ['nullable'],
            'ccm_enrol_date' => ['required_if:enrol_in_ccm,1'],
            'ccm_type' => ['required_if:enrol_in_ccm,1'],
            'rpm_enrol_date' => ['required_if:enrol_in_rpm,1'],
            'consent' => ['nullable'],

            'preferred_time' => ['required'],
            'preferred_communication' => ['required'],
            'preferred_language' => ['required'],

        ]);
        if ($request->patient_image != null) {
            $imageName = time() . '.' . $request->patient_image->extension();
            $request->patient_image->move(public_path('images/patients/'), $imageName);
            $data['patient_image'] = $imageName;
        }

        if ($request->enrol_in_ccm == "0") {
            $data['ccm_enrol_date'] = null;
        }

        if ($request->enrol_in_rpm == "0") {
            $data['rpm_enrol_date'] = null;
        }
        if ($request->device_id) {
            Device::where('id', $request->device_id)->update(['patient_id' => $patient->id]);
        }
        if ($request->chronic_condition_id) {
            $patient->chronic_conditions()->sync($request->chronic_condition_id);
        }

        $patient->update($data);
        $subject = 'Updated Patient';
        $description = 'Patient ' . $patient->first_name . ' ' . $patient->last_name . ' has been updated.';
        $this->logActivity($subject, $description, Patient::class, $patient->id);

        return  redirect()->route('home')->with('status', 'Patient has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('home')->with('status', 'Patient has been deleted');
    }

    public function last_checked(Request $request)
    {
        $patient = Patient::findOrFail($request->patient_id);
        $patient->update(['last_checked' => Carbon::now()]);
        return response(200);
    }

    public function enrol(Patient $patient)
    {
        $patient->update(['status' => '1']);
        return back()->with('status', 'Patient has been Enrolled');
    }
    public function unenrolled(Request $request, Patient $patient)
    {
        $request->validate([
            'un_enrolled_note' => 'nullable|string|max:65535',
            'enrollment_type' => 'required|in:ccm,rpm,both',
        ]);
        $patient_name = $patient->first_name . ' ' . $patient->last_name;
        $enrollmentType = $request->input('enrollment_type');
        $updates = [
            'un_enrolled_note' => $request->input('un_enrolled_note'),
        ];


        if ($enrollmentType === 'ccm') {
            $updates['enrol_in_ccm'] = false;
            $message = 'Patient ' . $patient_name . ' has been unenrolled from CCM.';
        } elseif ($enrollmentType === 'rpm') {
            $updates['enrol_in_rpm'] = false;
            if ($patient->enrol_in_rpm && $patient->device) {
                $patient->device->update(['patient_id' => null]);
            }
            $message = 'Patient ' . $patient_name . ' has been unenrolled from RPM.';
        } elseif ($enrollmentType === 'both') {
            $updates['enrol_in_ccm'] = false;
            $updates['enrol_in_rpm'] = false;
            if ($patient->enrol_in_rpm && $patient->device) {
                $patient->device->update(['patient_id' => null]);
            }
            $message = 'Patient ' . $patient_name . ' has been unenrolled from both CCM and RPM.';
        }

        $patient->update($updates);


        if (!$patient->enrol_in_ccm && !$patient->enrol_in_rpm) {
            $patient->update(['status' => '0']);
        }
        $subject = 'Unenrolled Patient';
        $description = $message;
        $this->logActivity($subject, $description, Patient::class, $patient->id);

        return redirect()->route('home')->with('status', $message);
    }


    public function update_patient_device(Request $request)
    {
        $request->validate([
            'device_serial_no' => ['required', 'string', 'min:12'],
            'device_imei_no'   => ['required', 'string'],
            'patient_id'       => ['required', 'exists:patients,id'],
            'install_date'     => ['nullable'],
            'setup_date'       => ['nullable']
        ]);

        $patient = Patient::find($request->patient_id);

        // Find if the requested device already exists in DB
        $existingDevice = Device::where('device_serial_no', $request->device_serial_no)
            ->orWhere('device_imei_no', $request->device_imei_no)
            ->first();

        // Error: device exists but is already assigned to another patient
        if ($existingDevice && $existingDevice->patient_id !== null && $existingDevice->patient_id !== $patient->id) {
            return back()->withErrors(['device_serial_no' => 'This device is already assigned to another patient.']);
        }

        // Condition 2: Free up patient's current device (make patient_id null)
        $currentDevice = $patient->device;
        if ($currentDevice) {
            $currentDevice->update(['patient_id' => null]);
        }

        if (!$existingDevice) {
            // Condition 1: Device doesn't exist — create new and assign to patient
            Device::create([
                'device_serial_no' => $request->device_serial_no,
                'device_imei_no'   => $request->device_imei_no,
                'patient_id'       => $patient->id,
                'install_date'     => $request->install_date,
                'setup_date'       => $request->setup_date
            ]);
        } else {
            // Condition 3: Device exists and is free — assign it to this patient
            $existingDevice->update([
                'patient_id'   => $patient->id,
                'install_date' => $request->install_date,
                'setup_date'   => $request->setup_date
            ]);
        }

        return back()->with('status', 'Device has been updated successfully');
    }

    public function logActivity($subject, $description, $modelType, $modelId)
    {
        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'model_type' => $modelType,
                'model_id' => $modelId,
                'subject' => $subject,
                'description' => $description,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Log Activity Error: ' . $e->getMessage());
        }
    }
}
