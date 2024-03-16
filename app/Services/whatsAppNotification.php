<?php

namespace App\Services;

use Twilio\Rest\Client;

class whatsAppNotification
{
    // protected $client;
    // protected $sid = "ACa2086f7bdc851336fc7d87fd5212c99c";
    // protected $token = "1c0f700072a0d6929e4f57325c46c928";
    // protected $from = '+14155238886';

    // public function __construct()
    // {
    //     $this->client = new Client($this->sid, $this->token);
    // }

    // public function sendWhatsAppMessage($to, $message)
    // {
    //     try {
    //         $this->client->messages->create(
    //             "whatsapp:$to",
    //             [
    //                 'from' => "whatsapp:" . $this->from,
    //                 'body' => $message,
    //             ]
    //         );
    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }
    // }


}
