<?php

namespace Application\Service;

use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Db\Sql\Select;

/**
 * Serviço responsável pela autenticação da aplicação
 *
 * @category Admin
 * @package Service
 */
class Auth extends Service {

   const DEFAULT_ROLE = "visitor";
   const DEFAULT_ROLE_ID = 1;

   /**
    * Adapter usado para a autenticação
    * @var Zend\Db\Adapter\Adapter
    */
   private $dbAdapter;

   /**
    * Construtor da classe
    *
    * @return void
    */
   public function __construct($dbAdapter = null) {
      $this->dbAdapter = $dbAdapter;
   }

   /**
    * Faz a autenticação dos usuários
    *
    * @param array $params
    * @return array
    */
   public function authenticate($params) {
      if (!isset($params['username']) || !isset($params['password'])) {
         throw new \Exception("Parâmetros inválidos");
      }
      
      //$adapter = $this->getServiceManager()->get("Zend\Db\Adapter\Adapter");
      //$cparams = $adapter->getDriver()->getConnection()->getConnectionParameters();
      //$salt = $cparams['salt'];
      //$password = hash('sha256', $params['password'] . $salt);
      $auth = new AuthenticationService();
      $authAdapter = new AuthAdapter($this->dbAdapter);
      $authAdapter->setTableName('users')
              ->setIdentityColumn('username')
              ->setCredentialColumn('password')
              ->setCredentialTreatment("sha256((? || salt)::bytea) AND verified = 'true'")
              ->setIdentity($params['username'])
              ->setCredential($params['password']);
      $select = $authAdapter->getDbSelect();
      $select->join(array('r' => 'acl_roles'), 'users.acl_roles_id = r.id', array('role'));

      $result = $auth->authenticate($authAdapter);
      if (!$result->isValid()) {
         throw new \Exception("Login ou senha inválidos");
      }

      //salva o user na sessão
      $session = $this->getServiceManager()->get('Session');
      $session->offsetSet('user', $authAdapter->getResultRowObject());

      return true;
   }

   /**
    * Faz o logout do sistema
    *
    * @return void
    */
   public function logout() {
      $auth = new AuthenticationService();
      $session = $this->getServiceManager()->get('Session');
      $session->offsetUnset('user');
      $auth->clearIdentity();
      return true;
   }

   /**
    * Faz a autorização do usuário para acessar o recurso
    * @param string $moduleName Nome do módulo sendo acessado
    * @param string $controllerName Nome do controller
    * @param string $actionName Nome da ação
    * @return boolean
    */
   public function authorize($moduleName, $controllerName, $actionName) {
      $auth = new AuthenticationService();
      $role = Auth::DEFAULT_ROLE;
      if ($auth->hasIdentity()) {
         $session = $this->getServiceManager()->get('Session');
         $user = $session->offsetGet('user');
         $role = $user->role;
      }
      $resource = $controllerName . '.' . $actionName;
      $acl = $this->getServiceManager()->get('Core\Acl\Builder')->build();
      if ($acl->isAllowed($role, $resource)) {
         return true;
      }
      return false;
   }

}
