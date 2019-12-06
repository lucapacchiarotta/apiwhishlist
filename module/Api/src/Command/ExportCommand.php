<?php

namespace Api\Command;

use Zend\Console\Adapter\AdapterInterface;
use ZF\Console\Route;

class ExportCommand {
    private $list;
    
    public function __construct($list) {
        $this->list = $list;
    }
    
    /**
     * @param Route $route
     * @param AdapterInterface $console
     * @throws \Doctrine\ORM\ORMException
     */
    public function __invoke(Route $route, AdapterInterface $console) {
        $path = $route->getMatches()['path'];
        $path .= '/' . date('YmdHis') . '.csv';
        $fileContent = "user;title wishlist;number of items\r\n";
        foreach ($this->list->findAll() as $item) {
            $items = $item->getItems();
            $count = 0;
            if ($items) {
                $items = json_decode($items);
                $count = count($items);
            }
            $console->writeLine("Export data for list {$item->getName()}");
            $fileContent .= "{$item->getUser()};{$item->getName()};$count\r\n";
        }
        file_put_contents($path, $fileContent);
    }
}