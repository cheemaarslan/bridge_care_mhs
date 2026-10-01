<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Patient;
use App\Models\Setting;
use App\Models\CarePlan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:crud_report')->only('report');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */




    public function index()
    {

        Log::info('Home page accessed by user ID: ' . auth()->user()->id);

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
            ->where('practice_id', auth()->user()->practice_id)
            ->where('enrol_in_ccm', true)->count();
        $remaining_care_plan = Patient::WhereDoesntHave('care_plan', function ($query) {
            $query->where('active', true);
        })
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('enrol_in_ccm', true)->count();
        $less_than_care_plan = Patient::whereHas('care_plan', function ($query) {
            $query->where('active', true);
            $query->where('minutes', '<', 10);
        })
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('enrol_in_ccm', true)->count();
        $greater_than_care_plan = Patient::whereHas('care_plan', function ($query) {
            $query->where('active', true);
            $query->where('minutes', '>=', 10);
        })
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('enrol_in_ccm', true)->count();


        $all_monthly_review = Patient::whereHas('monthly_review', function ($query) {
            $query->where('active', true);
        })
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('enrol_in_ccm', true)->count();
        $remaining_monthly_review = Patient::WhereDoesntHave('monthly_review', function ($query) {
            $query->where('active', true);
        })
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('enrol_in_ccm', true)->count();
        $less_than_monthly_review = Patient::whereHas('monthly_review', function ($query) {
            $query->where('active', true);
            $query->where('minutes', '<', 10);
        })
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('enrol_in_ccm', true)->count();
        $greater_than_monthly_review = Patient::whereHas('monthly_review', function ($query) {
            $query->where('active', true);
            $query->where('minutes', '>', 10);
        })
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('enrol_in_ccm', true)->count();

        $ccm_patients = null;
        $rpm_patients = null;
        $unenrolled_patients = null;


        $ccm_patient_count = Patient::where('enrol_in_ccm', true)
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->count();

        $rpm_patient_count = Patient::where('enrol_in_rpm', true)
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->count();

        $simple = Patient::where('enrol_in_ccm', true)
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('ccm_type', 'Simple')
            ->count();

        $complex = Patient::where('enrol_in_ccm', true)
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('ccm_type', 'Complex')
            ->count();

        $total_patient = $ccm_patient_count + $rpm_patient_count;

    $unenrolled = session('unenrolled', false);
$ccm = session('ccm', false);
$rpm = (!$ccm && !$unenrolled) ? true : session('rpm', false);


        $select_category_rpm = session('select_category_rpm', 'None');
        $select_status_rpm = session('select_status_rpm', 'None');
        $select_time_taken_rpm = session('select_time_taken_rpm', 'None');
        $select_last_checked_rpm = session('select_last_checked_rpm', 'None');


        $select_covid_status_ccm = session('select_covid_status_ccm', 'None');
        $select_gender_ccm = session('select_gender_ccm', 'None');
        $select_last_ccm_performed = session('select_last_ccm_performed', 'None');
        $select_minutes_rpm = session('select_minutes_rpm', 'None');
        $select_days_with_reading_rpm = session('select_days_with_reading_rpm', 'None');



        return view('home', compact(
            'to',
            'from',
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
            'select_days_with_reading_rpm'
        ));
    }

    // CCM Patients - Server-side DataTable
    public function ccmPatients(Request $request)
    {
        Log::info('CCM Patients DataTable requested by user ID: ' . auth()->user()->id);

        $query = Patient::query()
            ->with(['care_manager', 'care_plan'])
            ->where('enrol_in_ccm', true)
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id);

        if (auth()->user()->hasRole('care-manager') && !auth()->user()->can('view_practice_patient')) {
            $query->where('care_manager_id', auth()->user()->id);
        }

        $totalRecords = $query->count();

        if ($search = trim($request->input('search.value'))) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        $filteredRecords = $query->count();

        $query->orderBy('first_name', 'asc');

        $length = $request->input('length', 25);
        $start = $request->input('start', 0);

        $patients = $query->skip($start)->take($length)->get();

        $data = $patients->map(function ($patient, $index) use ($start) {
            $sr = $start + $index + 1;


            $enrolDate = $patient->formatted_ccm_enrol_date ?? '-';
            $enrolSort = $patient->ccm_enrol_date
                ? Carbon::parse($patient->ccm_enrol_date)->timestamp
                : 0;


            $carePlanDate = '-';
            $carePlanSort = 0;
            if ($patient->care_plan && $patient->care_plan->completed_at) {
                $carePlanDate = Carbon::parse($patient->care_plan->completed_at)->format('m-d-Y');
                $carePlanSort = Carbon::parse($patient->care_plan->completed_at)->timestamp;
            }


            $lastCcmDate = $patient->formatted_last_ccm_performed ?? '-';
            $lastCcmSort = $patient->last_ccm_performed
                ? Carbon::parse($patient->last_ccm_performed)->timestamp
                : Carbon::now()->subYears(10)->timestamp;

            return [
                $sr,
                '<a href="' . route('patient.show', ['patient' => $patient, 'type' => 'ccm']) . '"><strong>' .
                    $patient->first_name . ' ' . $patient->last_name . '</strong></a>',
                $patient->covid_status ?? '-',
                $patient->gender ?? '-',
                $patient->dob ?? '-',
                preg_replace('/[^0-9]/', '', str_replace('+1', '', $patient->contact_no ?? '')),
                $patient->email ?? '-',
                '<span data-sort="' . $enrolSort . '">' . $enrolDate . '</span>',
                $patient->care_manager?->user_name ?? '-',
                '<span data-sort="' . $carePlanSort . '">' . $carePlanDate . '</span>',
                '<span data-sort="' . $lastCcmSort . '">' . $lastCcmDate . '</span>',
                $patient->address ?? '-',
                '<div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="ti-settings"></i>
                </button>
                <div class="dropdown-menu slideInUp">
                    <a class="dropdown-item" href="' . route('patient.show', ['patient' => $patient, 'type' => 'ccm']) . '">
                        <i class="ti-eye"></i> Open
                    </a>
                    <a class="dropdown-item" href="' . route('patient.edit', $patient) . '">
                        <i class="ti-pencil-alt"></i> Edit
                    </a>
                </div>
            </div>',
            ];
        })->toArray();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    // RPM Patients - Server-side DataTable
    // public function rpmPatients(Request $request)
    // {
    //     Log::info('RPM Patients DataTable requested by user ID: ' . auth()->user()->id);

    //     $rpm_record_from = Setting::search('rpm_record_from');
    //     $to = Carbon::now()->toDateString();
    //     $from = Carbon::now()->subMonth()->toDateString();

    //     if ($rpm_record_from) {
    //         $from = $rpm_record_from;
    //     }

    //     $query = Patient::query()
    //         ->with([
    //             'last_patient_data',
    //             'doctor',
    //             'phone_call' => function ($q) use ($from, $to) {
    //                 $q->whereBetween('date', [$from, $to]);
    //             }
    //         ])
    //         ->with([
    //             'days_with_reading' => function ($q) use ($from, $to) {
    //                 $q->select('patient_id', DB::raw('DATE(date_time) as date'))
    //                     ->whereBetween('date_time', [$from, $to])
    //                     ->groupBy('patient_id', 'date');
    //             }
    //         ])
    //         ->withSum([
    //             'time_tracks' => function ($q) use ($from, $to) {
    //                 $q->whereBetween('engagement_date', [$from, $to]);
    //             }
    //         ], 'minutes')
    //         ->withSum([
    //             'time_tracks' => function ($q) use ($from, $to) {
    //                 $q->whereBetween('engagement_date', [$from, $to]);
    //             }
    //         ], 'seconds')


    //         ->withAvg('patient_data as avg_sys', 'data->sys')
    //         ->withAvg('patient_data as avg_dia', 'data->dia')
    //         ->withAvg('patient_data as avg_pul', 'data->pul')
    //             ->withCount([
    //             'days_with_reading as days_with_reading_count' => function ($q) use ($from, $to) {
    //                 $q->whereBetween('date_time', [$from, $to]);
    //             }
    //         ])

    //         ->where('enrol_in_rpm', true)
    //         ->where('status', true)
    //         ->where('practice_id', auth()->user()->practice_id);

    //     if (auth()->user()->hasRole('care-manager') && !auth()->user()->can('view_practice_patient')) {
    //         $query->where('care_manager_id', auth()->user()->id);
    //     }

    //     $totalRecords = $query->count();

    //          if ($search = trim($request->input('search.value'))) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('first_name', 'like', "%{$search}%")
    //                 ->orWhere('last_name', 'like', "%{$search}%")
    //                 ->orWhere('email', 'like', "%{$search}%")
    //                 ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
    //         });
    //     }

    //     $filteredRecords = $query->count();

    //     // $query->orderBy('first_name', 'asc');


    //     // $order = $request->input('order')[0] ?? ['column' => 8, 'dir' => 'asc']; // default to your desired col 8 asc
    //     // $colIdx = (int) $order['column'];
    //     // $dir = strtoupper($order['dir']) === 'DESC' ? 'DESC' : 'ASC';

    //     // switch ($colIdx) {
    //     //     case 1: // Patient name
    //     //         $query->orderBy('first_name', $dir)->orderBy('last_name', $dir);
    //     //         break;

    //     //     case 8:
    //     //         $query->orderByRaw("
    //     //         COALESCE(
    //     //                     UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(
    //     //                         (SELECT MAX(date_time)
    //     //                         FROM patient_data
    //     //                         WHERE patient_id = patients.id)
    //     //                     ),
    //     //                     9999999999
    //     //                 ) $dir
    //     //             ");
    //     //         break;

    //     //     case 9: // Last Checked
    //     //         $query->orderBy('last_checked', $dir);  // this is direct column on patients → no subquery needed
    //     //         break;

    //     //     case 11: // Days with reading
    //     //         // If you have withCount or alias, use it; otherwise add:
    //     //         // Earlier in query: ->withCount('days_with_reading as days_with_reading_count')
    //     //         $query->orderBy('days_with_reading_count', $dir);
    //     //         break;

    //     //     default:
    //     //         $query->orderBy('first_name', 'asc');
    //     // }



    //       $order = $request->input('order.0', ['column' => 1, 'dir' => 'asc']);
    //     $colIdx = (int) $order['column'];
    //     $dir    = strtoupper($order['dir']) === 'DESC' ? 'desc' : 'asc';



    //     switch ($colIdx) {
    //         case 1:
    //             $query->orderBy('first_name', $dir)->orderBy('last_name', $dir);
    //             break;
    //         case 2:
    //             $query->orderBy('avg_sys', $dir)->orderBy('avg_dia', $dir);
    //             break;

    //         case 3:
    //             $query->orderByRaw("
    //                 CASE
    //                     -- Highest priority first (for DESC to put Crisis on top)
    //                     WHEN avg_sys >= 165 OR avg_dia >= 120 THEN 4          -- Crisis
    //                     WHEN avg_sys >= 140 OR avg_dia >= 90 THEN 3            -- Stage-2 (broader to catch edge cases)
    //                     WHEN avg_sys >= 130 OR avg_dia >= 80 THEN 2            -- Stage-1 (broader)
    //                     WHEN avg_sys IS NULL OR avg_dia IS NULL
    //                         OR avg_sys <= 0 OR avg_dia <= 0
    //                     THEN 1                                                -- Invalid = Normal priority
    //                     ELSE 1                                                -- Normal
    //                 END {$dir}
    //             ");


    //             $query->orderByRaw("
    //                 COALESCE(
    //                     UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(
    //                         (SELECT MAX(date_time) FROM patient_data WHERE patient_id = patients.id)
    //                     ),
    //                     9999999999
    //                 ) ASC
    //             ");
    //             break;
    //         case 5:
    //             $query->orderByRaw("
    //                     CASE
    //                         WHEN (
    //                             SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.sys'))
    //                             FROM patient_data
    //                             WHERE patient_id = patients.id
    //                             ORDER BY date_time DESC LIMIT 1
    //                         ) IS NULL
    //                         OR (
    //                             SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.dia'))
    //                             FROM patient_data
    //                             WHERE patient_id = patients.id
    //                             ORDER BY date_time DESC LIMIT 1
    //                         ) IS NULL THEN 1

    //                         WHEN CAST((
    //                             SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.sys'))
    //                             FROM patient_data
    //                             WHERE patient_id = patients.id
    //                             ORDER BY date_time DESC LIMIT 1
    //                         ) AS SIGNED) >= 165
    //                         OR CAST((
    //                             SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.dia'))
    //                             FROM patient_data
    //                             WHERE patient_id = patients.id
    //                             ORDER BY date_time DESC LIMIT 1
    //                         ) AS SIGNED) >= 120 THEN 4

    //                         WHEN (CAST((
    //                             SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.sys'))
    //                             FROM patient_data
    //                             WHERE patient_id = patients.id
    //                             ORDER BY date_time DESC LIMIT 1
    //                         ) AS SIGNED) BETWEEN 140 AND 164)
    //                         OR (CAST((
    //                             SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.dia'))
    //                             FROM patient_data
    //                             WHERE patient_id = patients.id
    //                             ORDER BY date_time DESC LIMIT 1
    //                         ) AS SIGNED) BETWEEN 90 AND 119) THEN 3

    //                         WHEN (CAST((
    //                             SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.sys'))
    //                             FROM patient_data
    //                             WHERE patient_id = patients.id
    //                             ORDER BY date_time DESC LIMIT 1
    //                         ) AS SIGNED) BETWEEN 130 AND 139)
    //                         OR (CAST((
    //                             SELECT JSON_UNQUOTE(JSON_EXTRACT(data, '$.dia'))
    //                             FROM patient_data
    //                             WHERE patient_id = patients.id
    //                             ORDER BY date_time DESC LIMIT 1
    //                         ) AS SIGNED) BETWEEN 80 AND 89) THEN 2

    //                         ELSE 1
    //                     END {$dir}
    //                 ");
    //             break;
    //         case 6:
    //             $query->orderBy('avg_pul', $dir);
    //             break;
    //         case 7:
    //             $query->orderByRaw("JSON_EXTRACT(last_patient_data.data, '$.pul') {$dir}");
    //             break;
    //         case 8:
    //             $query->orderByRaw("
    //                 COALESCE(
    //                     UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(
    //                         (SELECT MAX(date_time) FROM patient_data WHERE patient_id = patients.id)
    //                     ),
    //                     9999999999
    //                 ) {$dir}
    //             ");
    //             break;
    //         case 9:
    //             $query->orderBy('last_checked', $dir);
    //             break;
    //         case 10:
    //             $query->orderBy('time_tracks_sum_minutes', $dir)
    //                 ->orderBy('time_tracks_sum_seconds', $dir);
    //             break;
    //         case 11:
    //             $query->orderBy('days_with_reading_count', $dir);
    //             break;
    //         case 12:
    //             $query->orderByRaw("CASE WHEN phone_call.id IS NOT NULL THEN 1 ELSE 0 END {$dir}");
    //             break;
    //         default:
    //             $query->orderBy('first_name', 'asc');
    //             break;
    //     }


    //     $length = $request->input('length', 100);
    //     $start = $request->input('start', 0);

    //     $patients = $query->skip($start)->take($length)->get();

    //     $data = $patients->map(function ($patient, $index) use ($start) {
    //         $sr = $start + $index + 1;

    //         $avg_sys = floor($patient->avg_sys ?? 0);
    //         $avg_dia = floor($patient->avg_dia ?? 0);
    //         $avg_pul = floor($patient->avg_pul ?? 0);

    //         $category = get_category($avg_sys, $avg_dia);

    //         $category_order = [
    //             'Normal' => 1,
    //             'Stage-1' => 2,
    //             'Stage-2' => 3,
    //             'Crisis' => 4
    //         ][$category] ?? 1;

    //         $lastData = $patient->last_patient_data;
    //         $status = $lastData?->category ?? 'Normal';

    //         $status_order = [
    //             'Normal' => 1,
    //             'Stage-1' => 2,
    //             'Stage-2' => 3,
    //             'Crisis' => 4
    //         ][$status] ?? 1;

    //         $last_sys = data_get($lastData, 'data.sys', '-');
    //         $last_dia = data_get($lastData, 'data.dia', '-');
    //         $last_pul = data_get($lastData, 'data.pul', '-');

    //         $total_seconds =
    //             ($patient->time_tracks_sum_minutes ?? 0) * 60 +
    //             ($patient->time_tracks_sum_seconds ?? 0);

    //         $time_taken_sort = $lastData
    //             ? Carbon::now()->timestamp - Carbon::parse($lastData->date_time)->timestamp
    //             : PHP_INT_MAX;

    //         $last_checked_sort = $patient->last_checked
    //             ? Carbon::now()->timestamp - Carbon::parse($patient->last_checked)->timestamp
    //             : PHP_INT_MAX;

    //         $daysCount = $patient->days_with_reading?->count() ?? 0;

    //         // $completedCall = ($patient->phone_call && $patient->phone_call->isNotEmpty()) ? 'Yes' : 'No';

    //         $completedCall = $patient->phone_call ? 'Yes' : 'No';


    //         return [
    //             $sr,
    //             '<a href="' . route('patient.show', ['patient' => $patient, 'type' => 'rpm']) . '">
    //             <strong>' . e($patient->first_name . ' ' . $patient->last_name) . '</strong>
    //         </a>',

    //             "<h5><span class=\"{$category}\">{$avg_sys}/{$avg_dia}</span></h5>",

    //             "<h5 data-sort=\"{$category_order}\">
    //             <span class=\"{$category}\">{$category}</span>
    //         </h5>",


    //             $lastData
    //                 ? "<h5><span class=\"{$lastData->category}\">{$last_sys}/{$last_dia}</span></h5>"
    //                 : '-',

    //             "<h5 data-sort=\"{$status_order}\">
    //             <span class=\"{$status}\">{$status}</span>
    //         </h5>",


    //             $avg_pul,


    //             $last_pul,

    //             "<span data-sort=\"{$time_taken_sort}\">" .
    //                 ($lastData?->formatted_date ?? '-') .
    //                 "</span>",

    //             "<span data-sort=\"{$last_checked_sort}\">" .
    //                 ($patient->formatted_last_checked ?? '-') .
    //                 "</span>",

    //             "<span data-sort=\"{$total_seconds}\">" .
    //                 configure_time_track(
    //                     $patient->time_tracks_sum_minutes ?? 0,
    //                     $patient->time_tracks_sum_seconds ?? 0
    //                 ) .
    //                 "</span>",

    //             $daysCount,
    //             $completedCall,
    //             $patient->covid_status ?? '-',
    //             $patient->doctor?->user_name ?? '-',

    //             '<div class="btn-group">
    //             <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
    //                 <i class="ti-settings"></i>
    //             </button>
    //             <div class="dropdown-menu slideInUp">
    //                 <a class="dropdown-item" href="' . route('patient.show', ['patient' => $patient, 'type' => 'rpm']) . '">
    //                     <i class="ti-eye"></i> Open
    //                 </a>
    //                 <a class="dropdown-item" href="' . route('patient.edit', $patient) . '">
    //                     <i class="ti-pencil-alt"></i> Edit
    //                 </a>
    //             </div>
    //         </div>',
    //         ];
    //     })->toArray();

    //     return response()->json([
    //         'draw' => (int) $request->input('draw'),
    //         'recordsTotal' => $totalRecords,
    //         'recordsFiltered' => $filteredRecords,
    //         'data' => $data,
    //     ]);
    // }



    public function rpmPatients(Request $request)
    {
        Log::info('RPM Patients DataTable requested by user ID: ' . auth()->user()->id);

        $rpm_record_from = Setting::search('rpm_record_from');
        $to   = Carbon::now()->toDateString();
        $from = Carbon::now()->subMonth()->toDateString();

        if ($rpm_record_from) {
            $from = $rpm_record_from;
        }

        // Single JOIN to summary table — no subqueries at all
        $query = Patient::query()
            ->select([
                'patients.*',
                DB::raw('FLOOR(COALESCE(rpm_sum.avg_sys, 0)) as avg_sys'),
                DB::raw('FLOOR(COALESCE(rpm_sum.avg_dia, 0)) as avg_dia'),
                DB::raw('FLOOR(COALESCE(rpm_sum.avg_pul, 0)) as avg_pul'),
                DB::raw('rpm_sum.last_sys'),
                DB::raw('rpm_sum.last_dia'),
                DB::raw('rpm_sum.last_pul'),
                DB::raw('rpm_sum.last_reading_time'),
                DB::raw('COALESCE(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(rpm_sum.last_reading_time), 9999999999) as time_since_last_reading'),
                DB::raw('COALESCE(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(patients.last_checked), 9999999999) as time_since_last_checked'),
                DB::raw('COALESCE(rpm_sum.total_minutes, 0) as time_tracks_sum_minutes'),
                DB::raw('COALESCE(rpm_sum.total_seconds, 0) as time_tracks_sum_seconds'),
                DB::raw('COALESCE(rpm_sum.days_with_reading_count, 0) as days_with_reading_count'),
                DB::raw('COALESCE(rpm_sum.has_phone_call, 0) as has_phone_call'),
                DB::raw('COALESCE(rpm_sum.category_order, 1) as category_order'),
                DB::raw('COALESCE(rpm_sum.status_order, 1) as status_order'),
            ])
            ->leftJoin('patient_rpm_summary as rpm_sum', 'rpm_sum.patient_id', '=', 'patients.id')
            ->with(['doctor:id,user_name'])
            ->where('enrol_in_rpm', true)
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id);

        if (auth()->user()->hasRole('care-manager') && !auth()->user()->can('view_practice_patient')) {
            $query->where('care_manager_id', auth()->user()->id);
        }

        // Get total before filtering
        $totalRecords = $query->count();

        // Apply search
        if ($search = trim($request->input('search.value'))) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        $filteredRecords = $query->count();

        // Chip: category filter
        if ($category = $request->input('filter_category')) {
            $map = ['Normal' => 1, 'Stage-1' => 2, 'Stage-2' => 3, 'Crisis' => 4];
            if (isset($map[$category])) {
                $query->where('rpm_sum.category_order', $map[$category]);
            }
        }

        // Chip: status filter
        if ($status = $request->input('filter_status')) {
            $map = ['Normal' => 1, 'Stage-1' => 2, 'Stage-2' => 3, 'Crisis' => 4];
            if (isset($map[$status])) {
                $query->where('rpm_sum.status_order', $map[$status]);
            }
        }

        // Chip: no data filter
        if ($request->input('filter_nodata')) {
            $query->whereNull('rpm_sum.last_reading_time');
        }

        // Ordering
        $order  = $request->input('order.0', ['column' => 8, 'dir' => 'asc']);
        $colIdx = (int) $order['column'];
        $dir    = strtoupper($order['dir']) === 'DESC' ? 'desc' : 'asc';

        switch ($colIdx) {
            case 1:
                $query->orderBy('first_name', $dir)
                    ->orderBy('last_name', $dir);
                break;
            case 2:
                $query->orderBy('rpm_sum.avg_sys', $dir)
                    ->orderBy('rpm_sum.avg_dia', $dir);
                break;
            case 3:
                $query->orderBy('rpm_sum.category_order', $dir)
                    ->orderBy('time_since_last_reading', 'asc');
                break;
            case 5:
                $query->orderBy('rpm_sum.status_order', $dir);
                break;
            case 6:
                $query->orderBy('rpm_sum.avg_pul', $dir);
                break;
            case 7:
                $query->orderByRaw("CAST(rpm_sum.last_pul AS SIGNED) {$dir}");
                break;
            case 8:
                $query->orderBy('time_since_last_reading', $dir);
                break;
            case 9:
                $query->orderBy('time_since_last_checked', $dir);
                break;
            case 10:
                $query->orderBy('rpm_sum.total_minutes', $dir)
                    ->orderBy('rpm_sum.total_seconds', $dir);
                break;
            case 11:
                $query->orderBy('rpm_sum.days_with_reading_count', $dir);
                break;
            case 12:
                $query->orderBy('rpm_sum.has_phone_call', $dir);
                break;
            default:
                $query->orderBy('time_since_last_reading', 'asc');
                break;
        }

        $length   = $request->input('length', 25);
        $start    = $request->input('start', 0);
        $patients = $query->skip($start)->take($length)->get();

        $data = $patients->map(function ($patient, $index) use ($start) {
            $sr      = $start + $index + 1;
            $avg_sys = floor($patient->avg_sys ?? 0);
            $avg_dia = floor($patient->avg_dia ?? 0);
            $avg_pul = floor($patient->avg_pul ?? 0);

            $category = get_category($avg_sys, $avg_dia);
            $last_sys = $patient->last_sys ?? '-';
            $last_dia = $patient->last_dia ?? '-';
            $last_pul = $patient->last_pul ?? '-';

            $status_map = [1 => 'Normal', 2 => 'Stage-1', 3 => 'Stage-2', 4 => 'Crisis'];
            $status     = $status_map[$patient->status_order] ?? 'Normal';

            $total_seconds =
                ($patient->time_tracks_sum_minutes ?? 0) * 60 +
                ($patient->time_tracks_sum_seconds ?? 0);

            $formatted_last_reading = $patient->last_reading_time
                ? Carbon::parse($patient->last_reading_time)->diffForHumans()
                : '-';

            $formatted_last_checked = $patient->last_checked
                ? Carbon::parse($patient->last_checked)->diffForHumans()
                : '-';

            $completedCall = $patient->has_phone_call ? 'Yes' : 'No';

            return [
                $sr,
                '<a href="' . route('patient.show', ['patient' => $patient, 'type' => 'rpm']) . '">
                <strong>' . e($patient->first_name . ' ' . $patient->last_name) . '</strong>
            </a>',
                "<h5><span class=\"{$category}\">{$avg_sys}/{$avg_dia}</span></h5>",
                "<h5 data-sort=\"{$patient->category_order}\">
                <span class=\"{$category}\">{$category}</span>
            </h5>",
                $last_sys && $last_dia && $last_sys !== '-'
                    ? "<h5><span class=\"{$status}\">{$last_sys}/{$last_dia}</span></h5>"
                    : '-',
                "<h5 data-sort=\"{$patient->status_order}\">
                <span class=\"{$status}\">{$status}</span>
            </h5>",
                $avg_pul ?: '-',
                $last_pul,
                "<span data-sort=\"{$patient->time_since_last_reading}\">{$formatted_last_reading}</span>",
                "<span data-sort=\"{$patient->time_since_last_checked}\">{$formatted_last_checked}</span>",
                "<span data-sort=\"{$total_seconds}\">" .
                    configure_time_track(
                        $patient->time_tracks_sum_minutes ?? 0,
                        $patient->time_tracks_sum_seconds ?? 0
                    ) .
                    "</span>",
                $patient->days_with_reading_count ?? 0,
                $completedCall,
                $patient->covid_status ?? '-',
                $patient->doctor?->user_name ?? '-',
                '<div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="ti-settings"></i>
                </button>
                <div class="dropdown-menu slideInUp">
                    <a class="dropdown-item" href="' . route('patient.show', ['patient' => $patient, 'type' => 'rpm']) . '">
                        <i class="ti-eye"></i> Open
                    </a>
                    <a class="dropdown-item" href="' . route('patient.edit', $patient) . '">
                        <i class="ti-pencil-alt"></i> Edit
                    </a>
                </div>
            </div>',
            ];
        })->toArray();

        return response()->json([
            'draw'            => (int) $request->input('draw'),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ]);
    }


    public function rpmStats(Request $request)
    {
        $rpm_record_from = Setting::search('rpm_record_from');
        $to   = Carbon::now()->toDateString();
        $from = Carbon::now()->subMonth()->toDateString();

        if ($rpm_record_from) {
            $from = $rpm_record_from;
        }

        $base = Patient::query()
            ->where('enrol_in_rpm', true)
            ->where('status', true)
            ->where('practice_id', auth()->user()->practice_id);

        if (auth()->user()->hasRole('care-manager') && !auth()->user()->can('view_practice_patient')) {
            $base->where('care_manager_id', auth()->user()->id);
        }

        // Single JOIN to summary table — everything pre-calculated
        $patients = $base
            ->select([
                'patients.id',
                DB::raw('FLOOR(COALESCE(rpm_sum.avg_sys, 0)) as avg_sys'),
                DB::raw('FLOOR(COALESCE(rpm_sum.avg_dia, 0)) as avg_dia'),
                DB::raw('rpm_sum.last_sys'),
                DB::raw('rpm_sum.last_dia'),
                DB::raw('COALESCE(rpm_sum.total_minutes, 0) as tracked_minutes'),
                DB::raw('COALESCE(rpm_sum.days_with_reading_count, 0) as days_count'),
                DB::raw('COALESCE(rpm_sum.has_phone_call, 0) as has_phone_call'),
            ])
            ->leftJoin('patient_rpm_summary as rpm_sum', 'rpm_sum.patient_id', '=', 'patients.id')
            ->get();

        $total         = $patients->count();
        $noData        = 0;
        $summaryNormal = 0;
        $summaryS1 = 0;
        $summaryS2 = 0;
        $summaryCrisis = 0;
        $statusNormal  = 0;
        $statusS1  = 0;
        $statusS2  = 0;
        $statusCrisis  = 0;
        $callsDone     = 0;
        $aboveGoal     = 0;
        $nearGoal  = 0;
        $belowGoal = 0;
        $noMins = 0;
        $totalMins     = 0;
        $totalDays     = 0;
        $perPatient    = [];

        foreach ($patients as $p) {
            $avg_sys  = floor($p->avg_sys ?? 0);
            $avg_dia  = floor($p->avg_dia ?? 0);
            $last_sys = (int)($p->last_sys ?? 0);
            $last_dia = (int)($p->last_dia ?? 0);
            $mins     = (int)($p->tracked_minutes ?? 0);

            // No data check
            if (!$p->last_sys && !$p->last_dia) {
                $noData++;
                $totalMins += $mins;
                if ($mins >= 20)     $aboveGoal++;
                elseif ($mins >= 12) $nearGoal++;
                elseif ($mins > 0)   $belowGoal++;
                else                 $noMins++;
                $perPatient[] = ['name' => '', 'mins' => $mins];
                continue;
            }

            // Avg BP category
            $category = get_category($avg_sys, $avg_dia);
            if ($category === 'Normal')      $summaryNormal++;
            elseif ($category === 'Stage-1') $summaryS1++;
            elseif ($category === 'Stage-2') $summaryS2++;
            elseif ($category === 'Crisis')  $summaryCrisis++;

            // Last BP status
            $status = get_category($last_sys, $last_dia);
            if ($status === 'Normal')      $statusNormal++;
            elseif ($status === 'Stage-1') $statusS1++;
            elseif ($status === 'Stage-2') $statusS2++;
            elseif ($status === 'Crisis')  $statusCrisis++;

            // Calls
            if ($p->has_phone_call) $callsDone++;

            // Minutes
            $totalMins += $mins;
            if ($mins >= 20)     $aboveGoal++;
            elseif ($mins >= 12) $nearGoal++;
            elseif ($mins > 0)   $belowGoal++;
            else                 $noMins++;

            // Days
            $totalDays += (int)($p->days_count ?? 0);

            $perPatient[] = ['name' => '', 'mins' => $mins];
        }

        $withData = $total - $noData;
        $avgDays  = $total > 0 ? round($totalDays / $total, 1) : 0;

        return response()->json([
            'total'         => $total,
            'noData'        => $noData,
            'withData'      => $withData,
            'callsDone'     => $callsDone,
            'totalMins'     => $totalMins,
            'avgDays'       => $avgDays,
            'summaryNormal' => $summaryNormal,
            'summaryS1'     => $summaryS1,
            'summaryS2'     => $summaryS2,
            'summaryCrisis' => $summaryCrisis,
            'statusNormal'  => $statusNormal,
            'statusS1'      => $statusS1,
            'statusS2'      => $statusS2,
            'statusCrisis'  => $statusCrisis,
            'aboveGoal'     => $aboveGoal,
            'nearGoal'      => $nearGoal,
            'belowGoal'     => $belowGoal,
            'noMins'        => $noMins,
            'perPatient'    => $perPatient,
            'from'          => $from,
            'to'            => $to,
        ]);
    }




    // Unenrolled Patients - Server-side DataTable
    public function unenrolledPatients(Request $request)
    {
        $query = Patient::query()
            ->where('status', false)
            ->where('practice_id', auth()->user()->practice_id);

        if (auth()->user()->hasRole('care-manager') && !auth()->user()->can('view_practice_patient')) {
            $query->where('care_manager_id', auth()->user()->id);
        }

        $totalRecords = $query->count();

        if ($search = trim($request->input('search.value'))) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        $filteredRecords = $query->count();

        $query->orderBy('first_name', 'asc');

        $length = $request->input('length', 25);
        $start = $request->input('start', 0);
        $patients = $query->skip($start)->take($length)->get();

        $data = $patients->map(function ($patient, $index) use ($start) {
            $sr = $start + $index + 1;

            return [
                $sr,
                '<a href="' . route('patient.show', ['patient' => $patient, 'type' => 'unenrolled_patient']) . '"><strong>' .
                    $patient->first_name . ' ' . $patient->last_name . '</strong></a>',
                $patient->gender ?? '-',
                $patient->contact_no ?? '-',
                '<div style="width:300px;">' . ($patient->address ?? '-') . '</div>',
                '<div style="max-width:550px; overflow-x:auto; height:40px;">' . ($patient->un_enrolled_note ?? '-') . '</div>',
                '<div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="ti-settings"></i>
                </button>
                <div class="dropdown-menu slideInUp">
                    <button class="dropdown-item" onclick="event.preventDefault(); document.getElementById(\'enrol-' . $patient->id . '\').submit();">
                        <i class="ti-eye"></i> Enrol
                    </button>
                    <form action="' . route('patient.enrol', $patient) . '" method="post" id="enrol-' . $patient->id . '">
                        ' . csrf_field() . '
                    </form>
                </div>
            </div>',
            ];
        })->toArray();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }




    public function getActivityLog()
    {
        $activityLogs =  ActivityLog::with('user')
            ->latest()
            ->limit(100)
            ->get();

        return view('log', compact('activityLogs'));
    }



    public function report($care_manager_id = "All", $date = "Current", $from = null, $to = null)
    {
        $care_managers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Care-Manager');
        })->get();
        $month = null;
        if ($date == "Current") {
            $month = Carbon::now()->month;
        }
        if ($date == "Last") {
            $month = Carbon::now()->month - 1;
        }


        $total_patient = 0;
        $simple_patient = 0;
        $complex_patient = 0;
        $ccm_patients = 0;
        $simple_completed_patient = 0;
        $complex_completed_patient = 0;


        $total_patient = Patient::where('enrol_in_ccm', true)->get();
        $ccm_patient = $total_patient;
        $simple_patient = Patient::where('enrol_in_ccm', true)->where('ccm_type', 'Simple')->get();
        $complex_patient = Patient::where('enrol_in_ccm', true)->where('ccm_type', 'Complex')->get();

        $total_completed_patient = Patient::where('enrol_in_ccm', true)->get();
        $simple_completed_patient = Patient::where('enrol_in_ccm', true)->where('ccm_type', 'Simple')->get();
        $complex_completed_patient = Patient::where('enrol_in_ccm', true)->where('ccm_type', 'Complex')->get();


        $total_hour = Patient::withSum('care_plan', 'minutes')->withSum('care_plan', 'seconds')
            ->withSum('monthly_review', 'minutes')->withSum('monthly_review', 'seconds')->where('enrol_in_ccm', true)->get();
        $simple_hour = Patient::withSum('care_plan', 'minutes')->withSum('care_plan', 'seconds')
            ->withSum('monthly_review', 'minutes')->withSum('monthly_review', 'seconds')->where('enrol_in_ccm', true)->where('ccm_type', 'Simple')->get();

        $complex_hour = Patient::withSum('care_plan', 'minutes')->withSum('care_plan', 'seconds')
            ->withSum('monthly_review', 'minutes')->withSum('monthly_review', 'seconds')->where('enrol_in_ccm', true)->where('ccm_type', 'Complex')->get();

        // dd($from, $to);
        if ($date == "Custom") {
            $total_completed_patient = Patient::whereHas('care_plan', function ($query) use ($from, $to) {
                $query->whereBetween('created_at', [$from, $to]);
            })->orWhereHas('monthly_review', function ($query) use ($from, $to) {
                $query->whereBetween('created_at', [$from, $to]);
            })->where('enrol_in_ccm', true)->get();


            $simple_completed_patient = $total_completed_patient->where('enrol_in_ccm', true)->where('ccm_type', 'Simple');
            $complex_completed_patient = $total_completed_patient->where('enrol_in_ccm', true)->where('ccm_type', 'Complex');


            $total_hour = Patient::withSum('care_plan', 'minutes')->withSum('care_plan', 'seconds')
                ->withSum('monthly_review', 'minutes')->withSum('monthly_review', 'seconds')->where('enrol_in_ccm', true)->whereBetween('last_ccm_performed', [$from, $to])->get();

            $simple_hour = Patient::withSum('care_plan', 'minutes')->withSum('care_plan', 'seconds')
                ->withSum('monthly_review', 'minutes')->withSum('monthly_review', 'seconds')->where('enrol_in_ccm', true)->where('ccm_type', 'Simple')->whereBetween('last_ccm_performed', [$from, $to])->get();

            $complex_hour = Patient::withSum('care_plan', 'minutes')->withSum('care_plan', 'seconds')
                ->withSum('monthly_review', 'minutes')->withSum('monthly_review', 'seconds')->where('enrol_in_ccm', true)->where('ccm_type', 'Complex')->whereBetween('last_ccm_performed', [$from, $to])->get();
        } else {

            $total_completed_patient = Patient::whereHas('care_plan', function ($query) use ($month) {
                $query->whereMonth('completed_at', $month);
            })->orWhereHas('monthly_review', function ($query) use ($month) {
                $query->whereMonth('completed_at', $month);
            })->where('enrol_in_ccm', true)->get();

            $simple_completed_patient = $total_completed_patient->where('enrol_in_ccm', true)->where('ccm_type', 'Simple');
            $complex_completed_patient = $total_completed_patient->where('enrol_in_ccm', true)->where('ccm_type', 'Complex');


            $total_hour = Patient::whereHas('care_plan', function ($query) use ($month) {
                $query->whereMonth('completed_at', $month);
            })->orWhereHas('monthly_review', function ($query) use ($month) {
                $query->whereMonth('completed_at', $month);
            })->withSum('care_plan', 'minutes')->withSum('care_plan', 'seconds')
                ->withSum('monthly_review', 'minutes')->withSum('monthly_review', 'seconds')->where('enrol_in_ccm', true)->get();

            $simple_hour = $total_hour->where('ccm_type', 'Simple');
            $complex_hour = $total_hour->where('ccm_type', 'Complex');
        }

        if ($care_manager_id != "All") {
            $ccm_patient = $ccm_patient->where('care_manager_id', $care_manager_id);
            $simple_patient = $simple_patient->where('care_manager_id', $care_manager_id);
            $complex_patient = $complex_patient->where('care_manager_id', $care_manager_id);


            $total_completed_patient = $total_completed_patient->where('care_manager_id', $care_manager_id);
            $simple_completed_patient = $simple_completed_patient->where('care_manager_id', $care_manager_id);
            $complex_completed_patient = $complex_completed_patient->where('care_manager_id', $care_manager_id);

            $total_hour = $total_hour->where('care_manager_id', $care_manager_id);
            $simple_hour = $simple_hour->where('care_manager_id', $care_manager_id);
            $complex_hour = $complex_hour->where('care_manager_id', $care_manager_id);
        }

        $ccm_patient = $ccm_patient->count();
        $simple_patient = $simple_patient->count();
        $complex_patient = $complex_patient->count();

        $total_completed_patient = $total_completed_patient->count();
        $simple_completed_patient = $simple_completed_patient->count();
        $complex_completed_patient = $complex_completed_patient->count();

        $total_care_plan_sum_minutes = $total_hour->sum('care_plan_sum_minutes');
        $total_care_plan_sum_seconds = $total_hour->sum('care_plan_sum_seconds');
        $total_monthly_review_sum_minutes = $total_hour->sum('monthly_review_sum_minutes');
        $total_monthly_review_sum_seconds = $total_hour->sum('monthly_review_sum_seconds');

        $simple_care_plan_sum_minutes = $simple_hour->sum('care_plan_sum_minutes');
        $simple_care_plan_sum_seconds = $simple_hour->sum('care_plan_sum_seconds');
        $simple_monthly_review_sum_minutes = $simple_hour->sum('monthly_review_sum_minutes');
        $simple_monthly_review_sum_seconds = $simple_hour->sum('monthly_review_sum_seconds');

        $complex_care_plan_sum_minutes = $complex_hour->sum('care_plan_sum_minutes');
        $complex_care_plan_sum_seconds = $complex_hour->sum('care_plan_sum_seconds');
        $complex_monthly_review_sum_minutes = $complex_hour->sum('monthly_review_sum_minutes');
        $complex_monthly_review_sum_seconds = $complex_hour->sum('monthly_review_sum_seconds');

        $total_seconds = ($total_care_plan_sum_minutes * 60) + $total_care_plan_sum_seconds + ($total_monthly_review_sum_minutes * 60) + $total_monthly_review_sum_seconds;
        $simple_seconds = ($simple_care_plan_sum_minutes * 60) + $simple_care_plan_sum_seconds + ($simple_monthly_review_sum_minutes * 60) + $simple_monthly_review_sum_seconds;
        $complex_seconds = ($complex_care_plan_sum_minutes * 60) + $complex_care_plan_sum_seconds + ($complex_monthly_review_sum_minutes * 60) + $complex_monthly_review_sum_seconds;

        $total_hours = intval($total_seconds / 3600);
        $total_minutes = intval($total_seconds % 60);

        $simple_hours = intval($simple_seconds / 3600);
        $simple_minutes = intval($simple_seconds % 60);

        $complex_hours = intval($complex_seconds / 3600);
        $complex_minutes = intval($complex_seconds % 60);

        return view('report.index', compact(
            'care_managers',
            'care_manager_id',
            'date',
            'ccm_patient',
            'simple_patient',
            'complex_patient',
            'total_completed_patient',
            'simple_completed_patient',
            'complex_completed_patient',
            'total_hours',
            'total_minutes',
            'simple_hours',
            'simple_minutes',
            'complex_hours',
            'complex_minutes'
        ));
    }


    public function custom_sort(Request $request)
    {
        if ($request->type == "ccm") {
            $request->session()->forget(['select_covid_status_ccm', 'select_gender_ccm', 'select_last_ccm_performed']);
        }
        if ($request->type == "rpm") {
            $request->session()->forget(['select_category_rpm', 'select_status_rpm', 'select_time_taken_rpm', 'select_last_checked_rpm', 'select_minutes_rpm', 'select_days_with_reading_rpm']);
        }
        if ($request->type == "tab") {
            $request->session()->forget(['ccm', 'rpm', 'unenrolled']);
        }

        $request->validate([
            'key' => ['required'],
            'value' => ['required']
        ]);

        $request->session()->put($request->key, $request->value);
    }

    public function reset_ccm_sort(Request $request)
    {
        $request->session()->forget(['select_covid_status_ccm', 'select_gender_ccm', 'select_last_ccm_performed']);
        return back();
    }
    public function reset_rpm_sort(Request $request)
    {
        $request->session()->forget(['select_category_rpm', 'select_status_rpm', 'select_time_taken_rpm', 'select_last_checked_rpm', 'select_minutes_rpm', 'select_days_with_reading_rpm']);
        return back();
    }
}
