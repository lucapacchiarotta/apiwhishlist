#!/usr/bin/env php

<?php 

use Zend\Console\Console;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\Glob;
use ZF\Console\Application;
use ZF\Console\Dispatcher;
use Api\Entity\Wishlist;

require_once __DIR__ . '/../vendor/autoload.php'; // Composer autoloader

$configuration = [];
foreach (Glob::glob('../config/{{*}}{{,*.local}}.php', Glob::GLOB_BRACE) as $file) {
    $configuration = ArrayUtils::merge($configuration, include $file);
}

// Prepare the service manager
$smConfig = isset($config['service_manager']) ? $configuration['service_manager'] : [];
$smConfig = new \Zend\Mvc\Service\ServiceManagerConfig($smConfig);

$serviceManager = new ServiceManager();
$smConfig->configureServiceManager($serviceManager);
$serviceManager->setService('ApplicationConfig', $configuration);

// Load modules
$serviceManager->get('ModuleManager')->loadModules();

$routes = [
    [
        'name' => 'export',
        'route' => '[--path=]',
        'description' => 'Export date in CSV',
        'short_description' => 'Export date in CSV',
        'options_descriptions' => [
            'path'   => 'Path on filesystem for saving export data',
        ],
        'defaults' => [
            'path'   => '/tmp',
        ],
        'handler' => function($route, $console) use ($serviceManager) {
            /** @var \Doctrine\ORM\EntityManager $entityManager */
            $entityManager = $serviceManager->get(\Doctrine\ORM\EntityManager::class);
            /** @var mixed $repository */
            $list = $entityManager->getRepository(Wishlist::class);
            //var_dump($entityManager);
            $handler = new \Api\Command\ExportCommand($list);
            return $handler($route, $console);
        }
    ],
];

$config = $serviceManager->get('config');
//var_dump($config);
$application = new Application(
    'APP', //$config['app'],
    '1.0', // $config['version'],
    $routes,
    Console::getInstance(),
    new Dispatcher()
);

$exit = $application->run();
exit($exit);