<?php

return [

    'collections' => [

        'default' => [

            'info' => [
                'title' => config('app.name'),
                'description' => 'Api of Cyclone, a featured SaaS platform including CMS, Minecraft, and Chatbot integrations. ',
                'version' => 'dev',
                'contact' => [],
            ],

            'servers' => [
                [
                    'url' => env('APP_URL'),
                    'description' => null,
                    'variables' => [],
                ],
            ],

            'tags' => [
                [
                    'name' => 'auth',
                    'description' => 'Authenticating users',
                ]

            ],

            'security' => [
                 GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement::create()->securityScheme('BearerToken'),
            ],

            // Non standard attributes used by code/doc generation tools can be added here
            'extensions' => [
                // 'x-tagGroups' => [
                //     [
                //         'name' => 'General',
                //         'tags' => [
                //             'user',
                //         ],
                //     ],
                // ],
            ],

            // Route for exposing specification.
            // Leave uri null to disable.
            'route' => [
                'uri' => '/openapi',
                'middleware' => [],
            ],

            // Register custom middlewares for different objects.
            'middlewares' => [
                'paths' => [
                    //
                ],
                'components' => [
                    //
                ],
            ],

        ],

    ],

    // Directories to use for locating OpenAPI object definitions.
    'locations' => [
        'callbacks' => [
            base_path('specifications/OpenApi/Callbacks'),
        ],

        'request_bodies' => [
            base_path('specifications/OpenApi/RequestBodies'),
        ],

        'responses' => [
            base_path('specifications/OpenApi/Responses'),
        ],

        'schemas' => [
            base_path('specifications/OpenApi/Schemas'),
        ],

        'security_schemes' => [
            base_path('specifications/OpenApi/SecuritySchemes'),
        ],
    ],

];
