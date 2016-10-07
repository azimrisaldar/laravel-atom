<?php

return [

   

    'gateway' => 'AtomPayment',                           

    'testMode'  => true,                                // True for Testing the Gateway [For production false]

    'Atom' => [                                    
        'ATOM_LOGIN'        => env('ATOM_LOGIN', ''),
        'ATOM_PASSWORD'     => env('ATOM_PASSWORD', ''),
        'ATOM_PORT'         => env('ATOM_PORT', ''),
        'ATOM_PRO_ID'       => env('ATOM_PRO_ID', ''),
        'ATOM_CLIENT_CODE'  => base64_encode(env('ATOM_CLIENT_CODE', '')),

        // Should be route address for url() function
        'successUrl' => env('ATOM_SUCCESS_URL', 'atom/response'),
        
    ],

    





];
