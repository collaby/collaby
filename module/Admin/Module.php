<?php

namespace Admin;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Admin\Model\AdminTemplateTable;
use Admin\Model\AdminTemplate;

class Module {
    
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Executada no bootstrap do módulo
     *
     * @param MvcEvent $e
     */
    public function onBootstrap($e) {
        
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Admin\Model\AdminTemplateTable' => function ($sm) {
                    $tableGateway = $sm->get('AdminTemplateTable');
                    $table = new AdminTemplateTable($tableGateway);
                    return $table;
                },
                'AdminTemplateTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $model = new AdminTemplate();
                    $resultSetPrototype->setArrayObjectPrototype($model);
                    return new TableGateway($model->getTableName(), $dbAdapter, null, $resultSetPrototype);
                }
            )
        );
    }
}
