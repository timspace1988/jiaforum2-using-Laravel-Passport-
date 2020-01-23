<?php

namespace App\Handlers;

use GuzzleHttp\Client;


class SmsHandler
{
    private $settings;

    function __construct($config){
        $this->settings = $config;
    }

    public function sendMessage($to, $message, $from='Anonymous', $provider=''){
        if(empty($provider)){
            $provider = $this->settings['default'];
        }
        if($provider == 'clicksend'){
            $this->sendViaClicksend($to, $message, $from);
        }else{
            return;
        }
    }

    private function sendViaClicksend($to,$message, $from){
        $http = new Client;
        //$http = new Client(['timeout' => 10.0]);

        $gateway = $this->settings['gateways']['clicksend'];

        $api = $gateway['api_url'];//'https://api-mapper.clicksend.com/http/v2/send.php?';


        $query = http_build_query([
            'method' => 'http',
            'username' => $gateway['username'],
            'key' => $gateway['key'],
            'to' => is_array($to)? implode(',', $to) : $to,
            'message' => $message,
            'senderid' => $from,
        ]);

        $response = $http->get($api.$query);

        // try{
        //     $response = $http->get($api.$query);
        // }catch(Exception $e){
        //     $m = $e->getMessage();
        //     dd($m);
        //     abort(500, 'Some error happened.');
        // }


        //$result = simplexml_load_string($response);//convert xml to an object

        //dd($response);
        return $response;
    }

    //This is a test using post method
    public function sendMessage2($to, $message){
        $http = new Client;

        $api = 'https://api-mapper.clicksend.com/http/v2/send.php';


        $post_variables = [
            'method' => 'http',
            'username' => 'timspace1988@hotmail.com',
            'key' => '989C27BD-9AE4-0A19-5505-00A959869BB9',
            'to' => is_array($to)? implode(',', $to) : $to,
            'message' => $message,
            'senderid' => 'jiaforum',
        ];

        $response = $http->request('POST', $api, ['form_params' => $post_variables]);

        $result = json_decode($response->getBody(), true);
        //dd($result);
        return;
    }
}
