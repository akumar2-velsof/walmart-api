<?php return [
    'baseUrl' => 'https://marketplace.walmartapis.com',
    'apiVersion' => 'v3',
    'operations' => [
        'getReport' => [
            'httpMethod' => 'GET',
            'uri' => '/{ApiVersion}/getReport',
            'responseModel' => 'Result',
            'data' => [
                'xmlRoot' => [
                    'name' => 'Price',
                ],
            ],
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type'     => 'string',
                    'location' => 'uri',
                ],
                'type' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'query',
                    'default' => 'buybox'
                ],
            ]
        ],
        'getItemReport' => [
            'httpMethod' => 'GET',
            'uri' => '/{ApiVersion}/getReport',
            'responseModel' => 'Result',
            'data' => [
                'xmlRoot' => [
                    'name' => 'Price',
                ],
            ],
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type'     => 'string',
                    'location' => 'uri',
                ],
                'type' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'query',
                    'default' => 'item'
                ],
            ]
        ]
    ],
    'models' => [
        'Result' => [
            'type' => 'object',
            'properties' => [
                'statusCode' => ['location' => 'statusCode'],
                'body' => ['location' => 'body']
            ]
        ]
    ]
];
