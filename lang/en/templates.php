<?php

use Carbon\Carbon;

return [

    /*
      |--------------------------------------------------------------------------
      | Template Language files
      |--------------------------------------------------------------------------
      |
      |
      */



'product' => [
            'text'=> 'Hello [name] Be the first to know about discounts and offers at [company_name]! Go to the link to join our VIP list: [link].',
            'vars'=>[
                [
                'placeholder'=>'[company_name]',
                'value'=>'Company Name Here'
                ],
                [
                    'placeholder'=>'[link]',
                    'value'=>'Link URL Here'
                ],
            ]
        ],
    'feedback' => [
        'text'=> 'Hello [name]! [business_name] is here to remind you about your [service] tomorrow at [time] with [first_name]. If you cannot show up, we kindly ask you to call [phone_number] to reschedule.',
        'vars'=>[
            [
                'placeholder'=>'[business_name]',
                'value'=>'Jacks Autos'
            ],
            [
                'placeholder'=>'[service]',
                'value'=>'MOT & Service'
            ],
            [
                'placeholder'=>'[phone_number]',
                'value'=>'000 0000 000'
            ],
            [
                'placeholder'=>'[time]',
                'value'=>Carbon::now()->format('H:i')
            ],
        ]
        ],
    'event' => [
        'text'=> 'Keep the kids happy this summer with free entry to [location] throughout the whole of [month]. Call or text to book a date: [business_number] and receive a [value] voucher. [company_name]',
        'vars'=>[
        [
            'placeholder'=>'[offer]',
            'value'=>'Offer Here'
        ],
        [
            'placeholder'=>'[month]',
            'value'=>Carbon::now()->format('MM')
        ],
        [
            'placeholder'=>'[location]',
            'value'=>'Somewhere special'
        ],
        [
            'placeholder'=>'[business_number]',
            'value'=>'999'
        ],
        [
            'placeholder'=>'[value]',
            'value'=>'1% discount'
        ],
        [
            'placeholder'=>'[company_name]',
            'value'=>'POLICE WARE'
        ],
            ]
    ],
    'offer'=>[
        'text'=>'Hello [name] We have a [offer] sale until the end of [month]. Visit [location] today on [address] for more info and special prices.',
        'vars'=>[
            [
                'placeholder'=>'[offer]',
                'value'=>'Offer Here'
            ],
            [
                'placeholder'=>'[month]',
                'value'=>Carbon::now()->format('MM')
            ],
            [
                'placeholder'=>'[location]',
                'value'=>'Somewhere special'
            ],
            [
                'placeholder'=>'[address]',
                'value'=>'123 your address'
            ],
        ]
    ],


];
