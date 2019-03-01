<?php

namespace App\Business\Api;

use GuzzleHttp\Client as SmsClient;

class BulletinMessenger
{
    protected $smsClient;
    protected $smsApiKey;
    public function __construct()
    {
        $this->smsApiKey = config('services.bulletin_sms.secret');
        $this->smsClient =  new SmsClient();
    }
    
    public function dispatch($phone, $smsTemplate, $smsDynamics)
    {
        $response = $this->smsClient->request('GET', 'https://www.bulletinmessenger.net/api/3/sms/out', [
            'query' => ['to' => $phone,'body' => strtr(strip_tags($smsTemplate['format']), $smsDynamics)],
            'headers' => ['Authorization' => "Bearer {$this->smsApiKey}"]
        ]);
        if($response->getStatusCode() == 200){
            return true;
        }else{
            return false;
        }
    }
}