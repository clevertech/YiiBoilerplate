<?php
/**
 * Specific config overrides for backend entry point at local developer workstation.
 */
return [
    // Backend entry point at local can afford Gii support (DO NOT ALLOW it on production!)
    'modules' => [
        'gii' => [
            'class' => 'system.gii.GiiModule',
            'ipFilters' => ['127.0.0.1'],
            // Password will be set in the local config (see `local.example.php`)
        ]
    ],
];
