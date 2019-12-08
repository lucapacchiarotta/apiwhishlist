<?php

namespace Api\Controller;

use Zend\View\Model\JsonModel;
use Api\Entity\Wishlist;

class IndexController extends AbstractApiController {
    
    
    public function __construct($em) {
        $this->em = $em;
    }
    
    /**
     * Creazione di una nuova lista dei desideri
     * @return \Zend\View\Model\JsonModel
     */
    public function createlistAction() {
        $this->_objResult['status'] = self::RISP_KO;
        
        try {
            
            
        } catch (\Exception $e) {
            $this->_objResult['db_err'] = $e->getMessage();
        }
        
        $request = $this->getRequest();
        $content = $request->getContent();
        
        if ($content) {
            $content = json_decode($content);
        }
        
        if ($content) {
            $listName = $content->listname;
            $user = $content->user;
            
            if (empty($listName) || empty($user)) {
                $this->_objResult['message'] = 'Missing mandatory data';
            } else {
                
                $item = $this->em
                    ->getRepository(Wishlist::class)
                    ->findOneBy(['name' => $listName]);
                
                if ($item) {
                    $this->_objResult['message'] = 'List name exists';
                } else {
                    $list = new Wishlist();
                    $list->setName($listName);
                    $list->setUser($user);
                    
                    $this->em->persist($list);
                    $this->em->flush();
                    
                    $this->_objResult['status'] = self::RISP_OK;
                    $this->_objResult['message'] = 'Item inserted';
                    $this->_objResult['extra'] = $listName;
                }
            }
        }
        
        return new JsonModel([
            $this->_objResult
        ]);
    }
    
    /**
     * Aggiunta di una voce ad una specifica lista dei desideri
     * @return \Zend\View\Model\JsonModel
     */
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
            $user = $content->user;
            
            if (empty($listName) || empty($listItem) || empty($user)) {
                $this->_objResult['message'] = 'Missing mandatory data';
            } else {
                
                $item = $this->em
                    ->getRepository(Wishlist::class)
                    ->findOneBy(['name' => $listName, 'user' => $user]);
                
                if (!$item) {
                    $this->_objResult['message'] = 'List not found';
                } else {
                    $items = $item->getItems();
                    
                    if (empty($items)) {
                        $items = [];
                    } else {
                        $items = json_decode($items);
                    }
                    $items[] = $listItem;
                    
                    $item->setItems(json_encode($items));
                    
                    //$this->em->persist($item);
                    $this->em->flush();
                    
                    $this->_objResult['status'] = self::RISP_OK;
                    $this->_objResult['message'] = 'Item inserted';
                    $this->_objResult['extra'] = "$listName:$listItem";
                }
            }
        }
        
        return new JsonModel([
            $this->_objResult
        ]);
    }
    
    /**
     * Torna gli elementi di una lista dei desideri specifica
     * @return \Zend\View\Model\JsonModel
     */
    public function getlistAction() {
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
                
                $item = $this->em
                    ->getRepository(Wishlist::class)
                    ->findOneBy(['name' => $listName]);
                
                if (!$item) {
                    $this->_objResult['message'] = 'List not found';
                } else {
                    $items = $item->getItems();
                    
                    if (empty($items)) {
                        $items = [];
                    } else {
                        $items = json_decode($items);
                    }
                    
                    $this->_objResult['status'] = self::RISP_OK;
                    $this->_objResult['data'] = $items;
                }
            }
        }
        
        return new JsonModel([
            $this->_objResult
        ]);
    }
}
