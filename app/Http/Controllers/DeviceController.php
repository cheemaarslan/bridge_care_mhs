<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Device;
use App\Models\Patient;
use App\Models\DeviceData;
use App\Models\PatientData;
use App\Models\DeviceStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->except('device_data','device_status');
        $this->middleware(['permission:read_device'])->only('index');
        $this->middleware(['permission:create_device'])->only('create','store');
        $this->middleware(['permission:update_device'])->only('update','edit');
        $this->middleware(['permission:delete_device'])->only('destroy');

    }
    public function index()
    {
        $devices = Device::all();
        return view('device.index', compact('devices'));
    }
    public function create()
    {
        $patients = Patient::doesntHave('device')->where('enrol_in_rpm', true)->get();
        return view('device.create', compact('patients'));

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'device_serial_no' => ['required','string','min:12', 'unique:devices'],
            'device_imei_no' => ['required','string', 'unique:devices'],
            'patient_id' => ['nullable'],
            'install_date' => ['nullable'],
            'setup_date' => ['nullable']
        ]);
        $device = Device::create($data);

        if($request->ajax()){
            return response()->json([
                'device' => $device,
                'status' => 200
            ]);
        }
        return back()->with('status', 'A New Device has been added');

    }
    public function show(Device $device)
    {
        return view('device.show', compact('device'));
    }
    public function edit(Device $device)
    {
        $patients = Patient::doesntHave('device')->where('enrol_in_rpm', true)->get();
        return view('device.edit', compact('device','patients'));

    }
    public function update(Request $request, Device $device)
    {
        $data = $request->validate([
            'device_serial_no' => ['required', 'string','min:12', Rule::unique('devices')->ignore($device)],
            'device_imei_no' => ['required','string', Rule::unique('devices')->ignore($device)],
            'patient_id' => ['nullable'],
            'install_date' => ['nullable'],
            'setup_date' => ['nullable']
        ]);
        $device->update($data);
        return redirect()->route('device.index')->with('status', 'Device has been updated');

    }
    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('device.index')->with('status', 'Device has been removed');
    }
    public function release(Device $device)
    {
        $device->update(['patient_id' => null]);
        return redirect()->route('device.index')->with('status', 'Device has been released');
    }

    public function device_data_filter(Request $request)
    {
        $from = Carbon::createFromFormat('m-d-Y', $request->from)->format('Y-m-d')." 00:00:00";
        $to = Carbon::createFromFormat('m-d-Y', $request->to)->format('Y-m-d')." 23:59:59";
        $pulse_rate = [];
        $diastolic = [];
        $systolic = [];
        $date = [];

        $data = PatientData::where('device_id', $request->device_id)
        ->whereBetween('created_at', [$from, $to])
        ->get();


        foreach($data as $key=>$value){
            $pulse_rate[$key] = $value->data['pul'];
            $diastolic[$key] = $value->data['dia'];
            $systolic[$key] = $value->data['sys'];
            $date[$key] = $value->formatted_date;
        }


        return response()->json([
            'date' => $date,
            'pulse_rate' => $pulse_rate,
            'diastolic' => $diastolic,
            'systolic' => $systolic,
        ]);
    }


  public function device_data(Request $request)
    {
                 Log::info('Device Data Received in DeviceController: ' . json_encode($request->all()));

        $request->validate([
            'deviceId' => ['required'],
            'createdAt' => ['required'],
            'data' => ['required'],
        ]);
        if(Device::where('device_serial_no', $request->deviceId)->exists()){
            $device = Device::where('device_serial_no', $request->deviceId)->first();
            if($device){
                PatientData::create([
                    'patient_id' => $device->patient_id,
                    'device_id' => $device->id,
                    'date_time' => Carbon::createFromTimestamp($request->createdAt),
                    'type' => 'Automatic',
                    'data' => $request->data
                ]);
            }
        }
         return response()->json([
            'success' => true,
            'status'  => 200
        ], 200);
    }
   
  
  
// public function device_status(Request $request)
// {
//     // 1. Raw payload
//     Log::info('[MIO][STATUS] Raw payload received', ['payload' => $request->all()]);

//     // 2. Validation
//     $request->validate([
//         'deviceId' => ['required'],
//         'createdAt' => ['required'],
//         'status' => ['required'],
//         'isTest' => ['required'],
//     ]);

//     // 3. Device lookup
//     $device = Device::where('device_serial_no', $request->deviceId)->first();
//     if (!$device) {
//         Log::warning('[MIO][STATUS] Device not found', ['deviceId' => $request->deviceId]);
//         return response()->json(['ignored' => true], 200);
//     }

//     // 4. Determine payload type
//     $status = $request->status;
//     $type = $status['data_type'] ?? null;
//     Log::info('[MIO][STATUS] Payload type detected', ['data_type' => $type]);

//     // 5. FINAL PATIENT READING
//     if (in_array($type, ['bpm_gen2_measure', 'bpm_gen2_result'])) {

//         // Defensive check for missing keys
//         if (!isset($status['sys'], $status['dia'], $status['pul'])) {
//             Log::warning('[MIO][STATUS] Reading packet missing values', [
//                 'device_id' => $device->id,
//                 'status' => $status
//             ]);
//         } else {
//             Log::info('[MIO][STATUS] Saving patient reading', ['device_id' => $device->id]);

//             PatientData::create([
//                 'patient_id' => $device->patient_id,
//                 'device_id' => $device->id,
//                 'date_time' => Carbon::createFromTimestamp($request->createdAt),
//                 'type' => 'Automatic',
//                 'data' => $status
//             ]);

//             Log::info('[MIO][STATUS] Patient reading saved', ['device_id' => $device->id]);
//         }

//         return response()->json(['saved' => 'patient_reading'], 200);
//     }

//     // 6. DEVICE STATUS / HEALTH
//     if (in_array($type, ['bpm_gen2_status', 'bpm_gen2_analysis'])) {

//         DeviceStatus::create([
//             'device_id' => $device->id,
//             'date_time' => Carbon::createFromTimestamp($request->createdAt),
//             'status' => $status,
//             'isTest' => $request->isTest
//         ]);

//         Log::info('[MIO][STATUS] Device status/analysis saved', ['device_id' => $device->id]);
//         return response()->json(['saved' => 'device_status'], 200);
//     }

//     // 7. Unknown packet type
//     Log::warning('[MIO][STATUS] Unknown data_type received', [
//         'device_id' => $device->id,
//         'data_type' => $type,
//         'status' => $status
//     ]);

//     return response()->json(['ignored' => true, 'reason' => 'unknown data_type'], 200);
// }


  
  
    public function device_status(Request $request)
    {
                Log::info('Device status Received in DeviceController: ' . json_encode($request->all()));

        $data = $request->validate([
            'deviceId' => ['required'],
            'createdAt' => ['required'],
            'status' => ['required'],
            'isTest' => ['required'],
        ]);
        if(Device::where('device_serial_no', $request->deviceId)->exists()){
            $device = Device::where('device_serial_no', $request->deviceId)->first();

            $data['device_id'] = $device->id;
            $data['date_time'] = Carbon::createFromTimestamp($request->createdAt);
            DeviceStatus::create($data);
        }
        return response(200);
    }
    
    public function search_device(Request $request)
    {
        $devices = Device::where('device_serial_no', 'LIKE', '%' . $request->query('query') . '%')
                         ->whereNull('patient_id')
                         ->select('id', 'device_serial_no', 'device_imei_no')
                         ->limit(10)
                         ->get();
    
        return response()->json($devices);
    }
}
