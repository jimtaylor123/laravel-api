<?php

use Spatie\QueryBuilder\Filters\FiltersExact;

return [
    'resources' => [

        'users' => [
            'allowedSorts'=> [
                'first_name',
                'last_name',
                'email',
            ],
            'allowedIncludes' => [
                'comments',
                'projects',
            ],
            'allowedFilters' => [],
            'validationRules'=> [
                'create' => [
                    'data.attributes.first_name' => 'required|string',
                    'data.attributes.last_name' => 'required|string',
                    'data.attributes.email' => 'required|email',
                    'data.attributes.password' => 'required|string',
                ],
                'update' => [
                    'data.attributes.first_name' => 'sometimes|required|string',
                    'data.attributes.last_name' => 'sometimes|required|string',
                    'data.attributes.email' => 'sometimes|required|email',
                    'data.attributes.password' => 'sometimes|required|string',
                ]
            ],
            'relationships' => [
                [
                    'type' => 'projects',
                    'method' => 'projects',
                ]
            ]
        ],
    ],
];
