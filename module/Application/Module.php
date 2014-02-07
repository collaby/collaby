<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Application\Model\Document;
use Application\Model\DocumentTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Template;
use Application\Model\TemplateTable;
use Application\Model\DocumentTemplate;
use Application\Model\DocumentTemplateTable;
use Locale;

class Module {

    const PRIORIDADE_DISPATCH = 100;
    
    public function onBootstrap($e) {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        /** @var \Zend\EventManager\SharedEventManager $sharedEvents */
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        //adiciona eventos ao módulo
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController',
                \Zend\Mvc\MvcEvent::EVENT_DISPATCH,
                array($this, 'mvcPreDispatch'),
                Module::PRIORIDADE_DISPATCH);
        
        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->setLocale(Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']))
                ->setFallbackLocale('en_US');
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Verifica se precisa fazer a autorização do acesso
     * @param MvcEvent $event Evento
     * @return boolean
     */
    public function mvcPreDispatch($event) {
        $di = $event->getTarget()->getServiceLocator();
        $routeMatch = $event->getRouteMatch();
        $moduleName = $routeMatch->getParam('module');
        $controllerName = $routeMatch->getParam('controller');
        $actionName = $routeMatch->getParam('action');

        $authService = $di->get('Application\Service\Auth');
        if (!$authService->authorize($moduleName, $controllerName, $actionName)) {
            throw new \Exception('Você não tem permissão para acessar este recurso.');
        }
        return true;
    }

    public function getServiceConfig() {
      return array(
          'factories' => array(
              'Application\Model\DocumentTable' => function($sm) {
                  $tableGateway = $sm->get('DocumentTable');
                  $table = new DocumentTable($tableGateway);
                  return $table;
               },
               'DocumentTable' => function ($sm) {
                  $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                  $resultSetPrototype = new ResultSet();
                  $model = new Document();
                  $resultSetPrototype->setArrayObjectPrototype($model);
                  return new TableGateway($model->getTableName(), $dbAdapter, null, $resultSetPrototype);
               },
              'Application\Model\TemplateTable' => function($sm) {
                  $tableGateway = $sm->get('TemplateTable');
                  $table = new TemplateTable($tableGateway);
                  return $table;
               },
               'TemplateTable' => function ($sm) {
                  $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                  $resultSetPrototype = new ResultSet();
                  $model = new Template();
                  $resultSetPrototype->setArrayObjectPrototype($model);
                  return new TableGateway($model->getTableName(), $dbAdapter, null, $resultSetPrototype);
               },
              'Application\Model\DocumentTemplateTable' => function($sm) {
                  $tableGateway = $sm->get('DocumentTemplateTable');
                  $table = new DocumentTemplateTable($tableGateway);
                  return $table;
               },
               'DocumentTemplateTable' => function ($sm) {
                  $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                  $resultSetPrototype = new ResultSet();
                  $model = new DocumentTemplate();
                  $resultSetPrototype->setArrayObjectPrototype($model);
                  return new TableGateway($model->getTableName(), $dbAdapter, null, $resultSetPrototype);
               },
          ),
      );
   }

}
