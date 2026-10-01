<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use App\Models\Patient;
use App\Models\PatientConsentForm;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['permission:crud_setting']);
    }
    public function index()
    {
        $setting = Setting::first();
        return view('setting.index', compact('setting'));
    }

    public function setting_general(Request $request)
    {
        $data=$request->validate([
            'app_name' => ['required', 'string', 'min:3', 'max:255'],
            'app_lgo' => ['nullable'],
            'languages' => ['required', 'array', 'min:1'],
            'engagement_types' => ['required', 'array', 'min:1'],
        ]);

        update_env('APP_NAME',$request->app_name);
        $setting = Setting::first();
        $setting->update($data);
        return back()->with('status','General Setting has been updated');


    }
    public function setting_rpm(Request $request)
    {
        $data = $request->validate([
            'setting_rpm' => ['nullable'],
            'rpm_record_from' => ['required_if:setting_rpm,1'],
        ]);
        if($request->setting_rpm == "1"){
            $setting = Setting::first();
            $setting->update($data);
            return back()->with('status','Rpm Record has been reset');

        }
        else{
            $from = Carbon::now()->format('m-d-Y');
            $setting = Setting::first();
            $setting->update(['rpm_record_from' => $from]);
    
            return back()->with('status','Rpm Record has been reset');

        }

        
    }
    public function setting_twilio(Request $request)
    {
        $request->validate([
            'account_sid' => ['required', 'string'],
            'auth_token' => ['required', 'string'],
            'ph_no' => ['required', 'string'],
        ]);
        update_env('TWILIO_SID',$request->account_sid);
        update_env('TWILIO_AUTH_TOKEN',$request->auth_token);
        update_env('TWILIO_NUMBER',$request->ph_no);



        return back()->with('status','TwiliO Integration has been updated');

    }
    public function setting_smtp(Request $request)
    {
        $request->validate([
            'mail_mailer' => ['required'],
            'mail_host' => ['required'],
            'mail_port' => ['required'],
            'mail_username' => ['required'],
            'mail_username' => ['required'],
            'mail_encryption' => ['required'],
        ]);
        
        update_env('MAIL_MAILER',$request->mail_mailer);
        update_env('MAIL_HOST',$request->mail_host);
        update_env('MAIL_PORT',$request->mail_port);
        update_env('MAIL_USERNAME',$request->mail_username);
        update_env('MAIL_PASSWORD',$request->mail_password);
        update_env('MAIL_ENCRYPTION',$request->mail_encryption);
        update_env('MAIL_FROM_ADDRESS',$request->mail_from_address);

        return back()->with('status', 'SMTP credential has been updated');

    }

    public function test(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);
        Mail::to($request->email)->send(new TestEmail());
        return back()->with('status', 'Your Test email has been sent');

       
    }
}
