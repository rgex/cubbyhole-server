<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\User;
use Application\Model\UserTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication;
use Zend\Authentication\Storage\Session as SessionStorage;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {/*
        return array('factories' => array(
            'Application\Model\UserTable' => function($sm){
                $tableGateway = $sm->get('UserTableGateway');
                $table = new UserTable($tableGateway);
                return $table;
            },
            'UserTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetAdapter = new ResultSet();
                $resultSetAdapter->setArrayObjectPrototype(new User());
                return new TableGateway('users',$dbAdapter,null,$resultSetAdapter);
            },
            'Application\Model\AuthStorage' => function($sm){
                return new Model\AuthStorage();
            },
            'AuthService' => function($sm){
                $authService = new Authentication\AuthenticationService();
                $authService->setStorage($sm->get('Application\Model\AuthStorage'));
                return $authService;
            }
        ));*/
    }

}
