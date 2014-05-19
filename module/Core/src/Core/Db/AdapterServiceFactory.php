<?php
namespace Core\Db;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
/**
 * Factory to build a DbAdapter
 *
 * @category   Core
 * @package    Db
 */
class AdapterServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $mvcEvent = $serviceLocator->get('Application')->getMvcEvent();
        if ($mvcEvent) {
            $routeMatch = $mvcEvent->getRouteMatch();
            $moduleName = $routeMatch->getParam('module');
            //if the module have a db configuration use it
            //$moduleConfig = include __DIR__ . '/../../../../../config/' . ucfirst($moduleName) . '/config/module.config.php';
            $moduleConfig = include __DIR__ . '/../../../../../config/autoload/global.php';
            $local = include __DIR__ . '/../../../../../config/autoload/local.php';
            $moduleConfig['db']['username'] = $local['db']['username'];
            $moduleConfig['db']['password'] = $local['db']['password'];
            if (isset($moduleConfig['db'])) 
                $config['db'] = $moduleConfig['db'];
        }
        return new Adapter($config['db']);
    }
}
