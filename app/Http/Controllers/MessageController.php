<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Message;
use App\Models\Patient;
use Twilio\Rest\Client;
use App\Services\Twilio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Twilio\Exceptions\TwilioException;
use Twilio\TwiML\MessagingResponse;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth'])->except('message_webhook');
        $this->middleware(['permission:read_message'])->only('index');
        $this->middleware(['permission:create_message'])->only('create','store');
        $this->middleware(['permission:update_message'])->only('update');
        $this->middleware(['permission:delete_message'])->only('destroy');

    }
    public function index()
    {
        //  $patients = DB::table('patients')
        //  ->leftJoin('messages','messages.patient_id','patients.id')
        //  ->select('patients.*', DB::raw('count(messages.id) as messages_count'))
        //  ->groupBy('patients.id')
        //  ->orderBy('messages.type', 'desc')
        //  ->get();
        // ->orderBy(Message::select('read')->whereColumn('patients.id', 'messages.patient_id')->groupBy('messages.patient_id'))
        $patients = Patient::with('latest_message')->withCount(['messages' => function($query){
            $query->where('read', 0);
        }])->get()->sortByDesc('latest_message.created_at');

        return view('message.index', compact('patients'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'msg' => ['required'],
            'patient_id' => ['required'],
        ]);
        $twilio = new Twilio();
        $patient = Patient::findOrFail($request->patient_id);
        if($request->to){
            if($request->to != $patient->contact_no) {
                $patient->update(['contact_no' => $request->to]);
            }

        }
        $message = null;
        $voice = null;



  try {
    if ($request->type == "both") {
        $message = $twilio->send_message($patient->contact_no, $request->msg);
        $voice   = $twilio->send_voice($patient->contact_no, $request->msg);
    } elseif ($request->type == "msg") {
        $message = $twilio->send_message($patient->contact_no, $request->msg);
    } else {
        $voice = $twilio->send_voice($patient->contact_no, $request->msg);
        return response()->json(['status' => 'ok'], 200);
    }
} catch (\Exception $e) {
    return response()->json([
        'error' => $e->getMessage()
    ], 500);
}

        if($request->type == "both" || $request->type=="msg"){

            Message::create([
                'patient_id' => $patient->id,
                'sid' => $message->sid,
                'body' => $message->body,
                'read' => true,
            ]);
        }


        return response(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function conversation_index(Request $request){
        Message::where('patient_id', $request->patient_id)->update(['read' => true]);
        $conversations = Message::where('patient_id', $request->patient_id)->orderBy('created_at', 'asc')->get();

        return response($conversations);
    }

    public function conversation_destroy(Request $request){
        Message::where('patient_id', $request->patient_id)->delete();
        return response(200);
    }
    public function message_webhook(Request $request)
    {
        $request->validate([
            'From' => ['required'],
            'Body' => ['required']
        ]);
        $patients = Patient::where('contact_no', $request->From)->get();
        if($patients->count() > 0){
            foreach($patients as $patient){
                Message::create([
                    'patient_id' => $patient->id,
                    'type' => 'Incoming',
                    'body' => $request->Body,
                    'read' => false,
                ]);
            }
        }
        $response = new MessagingResponse();
        $response->message('received');

        return $response;
    }
    public function un_read_message()
    {
        $messages = Patient::withCount(['messages' => function($query){
            $query->where('read', false);
        }])->whereNotNull('contact_no')->orderBy('first_name', 'asc')->get();

        return response($messages);
    }

}
