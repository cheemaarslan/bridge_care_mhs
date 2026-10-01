<?php 

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Twilio\Rest\Client;




class Twilio {
    protected $sid;
    protected $token;
    protected $twilio_number;
    protected $client;

//   public function __construct(){
//         $this->sid = getenv('TWILIO_SID');
//         $this->token = getenv('TWILIO_AUTH_TOKEN');
//         $this->twilio_number = getenv('TWILIO_NUMBER');

        
//         $this->client = new Client($this->sid, $this->token);
//     }
    
    
    public function __construct()
{
    $this->sid = config('services.twilio.sid');
    $this->token = config('services.twilio.token');
    $this->twilio_number = config('services.twilio.from');

    $this->client = new Client($this->sid, $this->token);
}



    public function send_message($to, $body){
        try{


            $message = $this->client->messages
            ->create($to, // to
                     ["body" => $body, "from" => $this->twilio_number]
            );
            return $message;
        }
        catch(Exception $exception){
            // return response($exception->getMessage());
            throw $exception;
        }
    }
    public function send_voice($to, $body)
    {
        try{
            $voice = $this->client->calls->create($to, $this->twilio_number,[
                "twiml" => "<Response><Say>".$body."</Say></Response>"
            ]);
    
            return $voice;
        }
        catch(Exception $exception){
            // return response($exception->getMessage());
            throw $exception;
        }

    }
}