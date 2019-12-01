<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api\Controller;

use Zend\View\Model\JsonModel;

class IndexController extends AbstractApiController {
    
    protected $_applicationSession;
    
    public function __construct($applicationSession) {
        $this->_applicationSession = $applicationSession;
    }
    
    public function indexAction() {
        return false;
    }
    
    public function createlistAction() {
        return new JsonModel([
            'status' => 'OK',
            'message'=>'Here is your data',
            'data' => [
                'full_name' => 'John Doe',
                'address' => '51 Middle st.'
            ]
        ]);
    }
    
    public function additemtolistAction() {
        return new JsonModel([
            'status' => 'OK',
            'message'=>'Here is your data',
            'data' => [
                'full_name' => 'John Doe',
                'address' => '51 Middle st.'
            ]
        ]);
    }
    
    public function getlistitemsAction() {
        return new JsonModel([
            'status' => 'OK',
            'message'=>'Here is your data',
            'data' => [
                'full_name' => 'John Doe',
                'address' => '51 Middle st.'
            ]
        ]);
    }
}
