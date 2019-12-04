<?php

namespace Api\Controller;

use Zend\View\Model\JsonModel;
use Application\Entity\Whishlist;

class IndexController extends AbstractApiController {
    
    protected $_applicationSession;
    
    public function __construct($applicationSession, $em) {
        $this->_applicationSession = $applicationSession;
        $this->em = $em;
    }
    
    public function createlistAction() {
        $this->_objResult['status'] = self::RISP_KO;
        
        //$lista = $this->em->getRepository(Whishlist::class)->findAll();
        //$this->_objResult['list'] = $lista;
        
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
        $this->_objResult['status'] = self::RISP_KO;
        
        $request = $this->getRequest();
        $content = $request->getContent();
        
        
        if ($content) {
            $content = json_decode($content);
        }
        
        if ($content) {
            $listName = $content->listname;
            $listItem = $content->listitem;
            if (empty($listName) || empty($listItem)) {
                $this->_objResult['message'] = 'List name and/or list item are empty';
            } else {
                if (!isset($this->_applicationSession->lists)) {
                    $this->_applicationSession->lists = array();
                }
                
                if (!isset($this->_applicationSession->lists[$listName])) {
                    $this->_applicationSession->lists = array();
                    $this->_objResult['message'] = 'List not found';
                } else {
                    $this->_applicationSession->lists[$listName]['items'][] = $listItem;

                    $this->_objResult['status'] = self::RISP_OK;
                    $this->_objResult['message'] = 'Item inserted';
                    $this->_objResult['extra'] = "$listName:$listItem";
                    $this->_applicationSession->lists[] = $listName;
                }
            }
        }
        $this->_objResult['aa'] = $this->_applicationSession->lists;
        return new JsonModel([
            $this->_objResult
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
