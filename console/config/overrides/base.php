<?php
/**
 * Overrides for configuration when we're in console application, i. e., in context of `yiic`.
 */
return [
    // Changing `application` path alias to point at `/console` subdirectory
    'basePath' => 'console',
    'commandMap' => [
        'migrate' => [
            'class' => 'system.cli.commands.MigrateCommand',
            'migrationPath' => 'application.migrations',
            'templateFile' => 'application.migrations.template.template'
        ]
    ],
];