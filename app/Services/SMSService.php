<?php

namespace App\Services;

use GuzzleHttp\Client;

class SMSService
{
    private $username;
    private $password;
    private $from;
    private $to;
    private $message;
    private $pattern_code;


    public function __construct(array $to)
    {
        $this->username = env("SMS_USERNAME");
        $this->password = env("SMS_PASSWORD");
        $this->from = env("SMS_NUMBER");
        $this->to = $to;
    }

    public function sendSMS()
    {
        //
    }

    public function sendPatternSMS(int $pattern, array $data)
    {
        $url = "http://37.130.202.188/patterns/pattern?username=" . $this->username . "&password=" . urlencode($this->password) . "&from=" . $this->from . "&to=" . json_encode($this->to) . "&input_data=" . urlencode(json_encode($data)) . "&pattern_code=" . $pattern;
        $client = new Client();
        $client->post($url, ['form_params' => $data]);
    }
}