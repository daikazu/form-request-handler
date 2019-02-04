<?php

return [
    //
    'table_prefix'          => '',

    //
    'send_to_email'         => env('FORM_REQUEST_TO_EMAIL_TOGGLE', false), // Turn on/off sending to TJM API
    'send_to_email_address' => env('FORM_REQUEST_SEND_TO_EMAIL', 'test@example.com'),
    'send_to_email_subject' => env('FORM_REQUEST_SEND_TO_EMAIL_SUBJECT', 'Form Request'),
    'send_to_email_otag'    => env('FORM_REQUEST_SEND_TO_EMAIL_OTAG', null),

    //
        'send_to_api'           => env('FORM_REQUEST_TO_API_TOGGLE', false), // Turn on/off sending to TJM API
    'api'                   => [
        'token'      => env('FORM_REQUEST_API_TOKEN'),
        'submit_url' => env('FORM_REQUEST_API_SUBMIT_URL'),
        'site_id'    => env('FORM_REQUEST_API_SITE_ID'),
    ],

    //
        'events'                => [
        'Daikazu\FormRequestHandler\Events\FormRequestSavedEvent' => [
            'Daikazu\FormRequestHandler\Listeners\FormRequestListener',
        ],
    ],


    'notifications'         => ['slack'], // slack

    'slack_webhook'         => env('FORM_REQUEST_SLACK_WEBHOOK'),
];
