<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Core\Security\Security;

/**
 * Description of UserTable
 *
 * @author atila
 */
class UserTable {
    
    protected $tableGateway;
    protected $_sequence = 'users_id_seq';
    
    public function __construct(TableGateway $tableGateway) {
      $this->tableGateway = $tableGateway;
   }
   
   // TODO: criar classe abstrata para tratar create, update, delete!
   /**
    * 
    * @param array $params
    * @return int
    */
   public function create($params) {
       $this->tableGateway->insert($params);
       return $this->tableGateway->getAdapter()->getDriver()->getLastGeneratedValue($this->_sequence);
   }
   
   public function signup($params) {
       $security = new Security();
       $salt = $security->create_hash($params['password']);
       $params['salt'] = $salt;
       
       $verifying_hash = $security->create_hash("changeme"); // used to verify email account
       $params['verifying_hash'] = $verifying_hash;
       
       $params['password'] = $security->salt_password($params['password'], $salt);
       
       $this->create($params);
   }
}
