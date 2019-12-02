<?php

namespace Api\Controller;

use Zend\View\Model\JsonModel;

class IndexController extends AbstractApiController {
    
    protected $_applicationSession;
    
    public function __construct($applicationSession) {
        $this->_applicationSession = $applicationSession;
    }
    
    public function createlistAction() {
        $result = 'KO';
        $errorDesc = '';
        
        $request = $this->getRequest();
        $content = $request->getContent();
        
        
        if ($content) {
            $content = json_decode($content);
        }
        
        if ($content) {
            $listName = $content->listname;
            if (empty($listName)) {
                $errorDesc = 'List name is empty';
            } else {
                if (!isset($this->_applicationSession->lists)) {
                    $this->_applicationSession->lists = array();
                }
                
                if (in_array($listName, $this->_applicationSession->lists)) {
                    $errorDesc = 'List name is already in list';
                } else {
                    $result = 'OK';
                    $errorDesc = 'Inserted';
                    $this->_applicationSession->lists[] = $listName;
                }
            }
        }
        
        return new JsonModel([
            'status' => $result,
            'error'  => $errorDesc
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
