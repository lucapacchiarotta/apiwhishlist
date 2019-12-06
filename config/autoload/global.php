<?php

use Zend\Session\Storage\SessionArrayStorage;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;


return [
    // Session configuration.
    'session_config' => [
        // Session cookie will expire in 30 days.
        'cookie_lifetime' => 30 * 24 * 60 * 60 * 1,
        // Session data will be stored on server maximum for 30 days.
        'gc_maxlifetime'  => 60 * 60 * 24 * 30,
        // 30 days
        'remember_me_seconds' => 30 * 24 * 60 * 60 * 1
    ],
    // Session manager configuration.
    'session_manager' => [
    ],
    // Session storage configuration.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
    'session_containers' => [
        'ApplicationSession'
    ]
];
