<?php

return [
    'baseUrl' => 'https://marketplace.walmartapis.com',
    'apiVersion' => 'v3',
    'operations' => [
        'List' => [
            'httpMethod' => 'GET',
            'uri' => '/{ApiVersion}/feeds',
            'responseModel' => 'Result',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ],
                'feedId' => [
                    'required' => false,
                    'type' => 'string',
                    'location' => 'query',
                ],
                'limit' => [
                    'required' => false,
                    'type' => 'integer',
                    'location' => 'query',
                    'maximum' => 50,
                ],
                'offset' => [
                    'required' => false,
                    'type' => 'integer',
                    'location' => 'query',
                ],
            ],
        ],
        'Get' => [
            'httpMethod' => 'GET',
            'uri' => '/{ApiVersion}/feeds/{feedId}',
            'responseModel' => 'Result',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ],
                'feedId' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ],
                'includeDetails' => [
                    'required' => false,
                    'type' => 'string',
                    'location' => 'query',
                ],
                'limit' => [
                    'required' => false,
                    'type' => 'integer',
                    'location' => 'query',
                    'maximum' => 50,
                ],
                'offset' => [
                    'required' => false,
                    'type' => 'integer',
                    'location' => 'query',
                ],
            ],
        ],
        'GetFeedItem' => [
            'httpMethod' => 'GET',
            'uri' => '/{ApiVersion}/feeds/feeditems/{feedId}?{+nextCursor}',
            'responseModel' => 'Result',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ],
                'feedId' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ],
                'includeDetails' => [
                    'required' => false,
                    'type' => 'string',
                    'location' => 'query',
                ],
                'limit' => [
                    'required' => false,
                    'type' => 'integer',
                    'location' => 'query',
                    'maximum' => 50,
                ],
                'nextCursor' => [
                    'required' => false,
                    'type' => 'string',
                    'location' => 'uri',
                ],
            ],
        ],
        'updateLagtime' => [
            'httpMethod' => 'POST',
            'uri' => '/v2/feeds',
            'responseModel' => 'Result',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type' => 'string',
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
                    'default' => 'lagtime',
                ],
                'file' => [
                    'required' => true,
                    'type' => 'object',
                    'location' => 'postFile',
                ]
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
