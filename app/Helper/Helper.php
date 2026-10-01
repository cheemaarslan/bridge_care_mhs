<?php

use App\Models\Code;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\TimeTrack;


function enrolled_patient()
{
    return Patient::where('status','1')->count();
}
function unenrolled_patient()
{
    return Patient::where('status','0')->count();
}
function appointment_count()
{
    return Patient::count();
}
function update_env($key, $value)
{
    $path = base_path('.env');

    if (file_exists($path)) {

        file_put_contents($path, str_replace(
            $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
        ));
    }
}
function set_format($date)
{
    if($date){
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
    else{
        return Carbon::now()->format('Y-m-d');
    }
}
function current_month_time($patient_id)
{
    $minutes = TimeTrack::where('patient_id', $patient_id)
    ->whereMonth('engagement_date', Carbon::now()->month)->sum('minutes');

    $seconds=TimeTrack::where('patient_id', $patient_id)
    ->whereMonth('engagement_date', Carbon::now()->month)->sum('seconds');

    return configure_time_track($minutes, $seconds);
}

function configure_time_track($minutes, $seconds)
{
    $total_seconds = ($minutes*60)+$seconds;
    $actual_minutes = floor($total_seconds/60);
    $actual_seconds = $total_seconds%60;
    return $actual_minutes.':'.$actual_seconds;


}
function configure_note($code, $days_with_reading, $time_track)
{
    $note = '';
    $time = '';
    if($code == "99458"){
        $note = "Spent 20 minutes viewing and interpreting patient data";
    }
    return $note;
}
function configure_code($patient_id)
{
    $code = "99457";
    $total_minutes = TimeTrack::where('patient_id', $patient_id)
    ->whereMonth('engagement_date', Carbon::now()->month)->sum('minutes');

    if($total_minutes >= 20){
        $code = "99458";
    }
    return $code;
}
function get_category($sys, $dia){
    if($sys > 0 && $dia > 0){
        $category = "Crisis";
        if($sys <= 129 && $dia <= 79){
            $category = "Normal";
        }
        if(in_array($sys, range(130,139)) || in_array($dia, range(80,89))){
            $category = "Stage-1";
        }
        if(in_array($sys, range(140,164)) || in_array($dia, range(90,119))){
            $category = "Stage-2";
        }
        if($sys >= 165 || $dia >= 120){
            $category = "Crisis";
        }
        return $category;
    }
    else{
        return '-';
    }
}
function set_start($date, $time)
{
    $date = Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    return $date.'T'.$time.':00';
}

function set_end($date, $time)
{
    $date = Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    return $date.'T'.$time.':00';
}
