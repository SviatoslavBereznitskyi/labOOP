<?php

return [

    'client' => [
        'consumerSecret'     => function_exists('env') ? env('UPWORK_SECRET', '') : '',
        'consumerKey'        => function_exists('env') ? env('UPWORK_KEY', '') : '',
        'authType'           => 'OAuth1',
      //  'ACCESS_TOKEN'       => function_exists('env') ? env('UPWORK_TOKEN', '') : '',
    ]
];