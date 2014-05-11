<?php

namespace Core\Acl;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Builder implements ServiceManagerAwareInterface {

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Retrieve serviceManager instance
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceManager() {
        return $this->serviceManager;
    }

    /**
     * Constroi a ACL
     * @return Acl
     */
    public function build() {
        $acl = new Acl();

        $this->_loadRoles($acl);
        
        $this->_loadResources($acl);
        
        $this->_loadPrivileges($acl);
        
        return $acl;
    }

    private function _loadRoles($acl) {
       $adapter = $this->getServiceManager()->get('Zend\Db\Adapter\Adapter');
       $sql = "SELECT r.id, r.role, pr.role as parent_role
         FROM acl_roles r
         LEFT JOIN acl_roles pr ON r.parent = pr.id
         ORDER BY r.id ASC";
       $st = $adapter->query($sql);
       $rs = $st->execute();
       //$this->getServiceManager()->get('Zend\Log')->info(print_r($rs));
       foreach($rs as $row) {
          $acl->addRole(new Role($row['role']), $row['parent_role']);
       }
    }
    
    private function _loadResources($acl) {
       $adapter = $this->getServiceManager()->get('Zend\Db\Adapter\Adapter');
       $sql = "SELECT module, controller, action
         FROM acl_resources r
         INNER JOIN acl_modules m ON r.module_id = m.id
         INNER JOIN acl_controllers c ON r.controller_id = c.id
         INNER JOIN acl_actions a ON r.action_id = a.id";
       $st = $adapter->query($sql);
       $rs = $st->execute();
       foreach($rs as $row) {
          $r = "{$row['module']}\\Controller\\{$row['controller']}.{$row['action']}";
          $acl->addResource(new Resource($r));
       }
    }
    
    private function _loadPrivileges($acl) {
       $adapter = $this->getServiceManager()->get('Zend\Db\Adapter\Adapter');
       $sql = "SELECT module, controller, action, role, allow
         FROM acl_privileges p
         INNER JOIN acl_resources r ON p.resource_id = r.id
         INNER JOIN acl_modules m ON r.module_id = m.id
         INNER JOIN acl_controllers c ON r.controller_id = c.id
         INNER JOIN acl_actions a ON r.action_id = a.id
         INNER JOIN acl_roles ro ON p.role_id = ro.id";
       $st = $adapter->query($sql);
       $rs = $st->execute();
       foreach($rs as $row) {
          $r = "{$row['module']}\\Controller\\{$row['controller']}.{$row['action']}";
          if ($row['allow']) {
             $acl->allow($row['role'], $r);
          }
       }
    }
}
