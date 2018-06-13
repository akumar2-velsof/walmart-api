<?php return [
    'baseUrl' => 'https://marketplace.walmartapis.com',
    'apiVersion' => 'v3',
    'operations' => [
        'bulkPromoPrice' => [
            'httpMethod' => 'POST',
            'uri' => '/{ApiVersion}/feeds',
            'responseModel' => 'Result',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type'     => 'string',
                    'location' => 'uri',
                ],
                'Content-type' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'header',
                    'default' => 'multipart/form-data',
                ],
                'Accept' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'header',
                    'default' => 'application/xml',
                ],
                'feedType' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'query',
                    'default' => 'promo',
                ],
                'file' => [
                    'required' => true,
                    'type' => 'object',
                    'location' => 'postFile',
                ],
            ],
        ]
    ],
    'models' => [
        'Result' => [
            'type' => 'object',
            'properties' => [
                'statusCode' => ['location' => 'statusCode'],
            ],
            'additionalProperties' => [
                'location' => 'xml'
            ],
        ]
    ]

];