<?php
namespace Api\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Api\Controller\IndexController;
use Doctrine\ORM\EntityManager;

class IndexControllerFactory implements FactoryInterface {
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $applicationSession = $container->get('ApplicationSession');
        $em = $container->get(EntityManager::class);
        //$em = $container->get('doctrine.entitymanager.orm_default');
        
        return new IndexController($applicationSession, $em);
    }
}
