<?php

namespace Api\Controller;

use Zend\View\Model\JsonModel;

class IndexController extends AbstractApiController {
    
    protected $_applicationSession;
    
    public function __construct($applicationSession) {
        $this->_applicationSession = $applicationSession;
    }
    
    public function createlistAction() {
        $this->_objResult['status'] = self::RISP_KO;
        
        $request = $this->getRequest();
        $content = $request->getContent();
        
        
        if ($content) {
            $content = json_decode($content);
        }
        
        if ($content) {
            $listName = $content->listname;
            if (empty($listName)) {
                $this->_objResult['message'] = 'List name is empty';
            } else {
                if (!isset($this->_applicationSession->lists)) {
                    $this->_applicationSession->lists = array();
                }
                
                if (in_array($listName, $this->_applicationSession->lists)) {
                    $this->_objResult['message'] = 'List name is already in list';
                } else {
                    $this->_objResult['status'] = self::RISP_OK;
                    $this->_objResult['message'] = 'Item inserted';
                    $this->_objResult['extra'] = $listName;
                    $this->_applicationSession->lists[] = $listName;
                }
            }
        }
        
        return new JsonModel([
            $this->_objResult
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
