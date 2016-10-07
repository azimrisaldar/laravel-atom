<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Indipay Service Config
    |--------------------------------------------------------------------------
    |   gateway = CCAvenue / PayUMoney / EBS / Citrus / InstaMojo
    |   view    = File
    */

    'gateway' => 'AtomPayment',                           // Replace with the name of default gateway you want to use

    'testMode'  => true,                                // True for Testing the Gateway [For production false]

    'Atom' => [                                    // PayUMoney Parameters
        'ATOM_LOGIN'        => env('ATOM_LOGIN', ''),
        'ATOM_PASSWORD'     => env('ATOM_PASSWORD', ''),
        'ATOM_PORT'         => env('ATOM_PORT', ''),
        'ATOM_PRO_ID'       => env('ATOM_PRO_ID', ''),
        'ATOM_CLIENT_CODE'  => base64_encode(env('ATOM_CLIENT_CODE', '')),

        // Should be route address for url() function
        'successUrl' => env('ATOM_SUCCESS_URL', 'atom/response'),
        
    ],

    





];
