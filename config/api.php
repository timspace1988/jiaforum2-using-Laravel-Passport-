<?php

return [
    //Limit of accessing the apis

    'rate_limits' => [
        //limit of visit times/min
        'access' => env('RATE_LIMITS', '60,1'),
        //limit of sign in
        'sign' => env('SIGN_RATE_LIMITS', '10,1'),
    ],
];
