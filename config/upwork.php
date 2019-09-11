<?php

return [

    'CONSUMER_SECRET'     => function_exists('env') ? env('UPWORK_SECRET', '') : '',
    'ACCESS_TOKEN'        => function_exists('env') ? env('UPWORK_TOKEN', '') : '',

];