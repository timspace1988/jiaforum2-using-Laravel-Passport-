<?php

return [
    //HTTP request overtime
    'timeout' => 10.0,

    //Default gateway
    'default' => 'clicksend',


    //Avaliable gateways
    'gateways' => [
        'clicksend' =>[
            'api_url' => env('CLICKSEND_API'),
            'username' => env('CLICKSEND_USERNAME'),
            'key' => env('CLICKSEND_API_KEY'),
            //'senderid' => env('CLICKSEND_FROM', 'Anonymous'),
        ],
    ],
];
