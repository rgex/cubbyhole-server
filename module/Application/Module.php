<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Model\Offer;
use Application\Model\OfferTable;
use Application\Model\Token;
use Application\Model\TokenTable;
use Application\Model\Worker;
use Application\Model\WorkerTable;
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
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'authPreDispatch'));
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'checkAcl'));
        $this->initAcl($e);
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
    {
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
            'Application\Model\OfferTable' => function($sm){
                    $tableGateway = $sm->get('OfferTableGateway');
                    $table = new OfferTable($tableGateway);
                    return $table;
            },
            'OfferTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetAdapter = new ResultSet();
                    $resultSetAdapter->setArrayObjectPrototype(new Offer());
                    return new TableGateway('offers',$dbAdapter,null,$resultSetAdapter);
             },
            'Application\Model\WorkerTable' => function($sm){
                    $tableGateway = $sm->get('WorkerTableGateway');
                    $table = new WorkerTable($tableGateway);
                    return $table;
            },
            'WorkerTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetAdapter = new ResultSet();
                    $resultSetAdapter->setArrayObjectPrototype(new Worker());
                    return new TableGateway('workers',$dbAdapter,null,$resultSetAdapter);
            },
            'Application\Model\TokenTable' => function($sm){
                    $tableGateway = $sm->get('TokenTableGateway');
                    $table = new TokenTable($tableGateway);
                    return $table;
            },
            'TokenTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetAdapter = new ResultSet();
                    $resultSetAdapter->setArrayObjectPrototype(new Token());
                    return new TableGateway('tokens',$dbAdapter,null,$resultSetAdapter);
            },
            'Application\Model\AuthStorage' => function($sm){
                return new Model\AuthStorage();
            },
            'AuthService' => function($sm){
                $authService = new Authentication\AuthenticationService();
                $authService->setStorage($sm->get('Application\Model\AuthStorage'));
                return $authService;
            }
        ));
    }

    public function authPreDispatch(MvcEvent $e)
    {
        $matches = $e->getRouteMatch();

        if(!$matches instanceof RouteMatch)
        {
            return false;
        }
        $controller = $matches->getParam('controller');
        $app  = $e->getApplication();
        $sm   = $app->getServiceManager();
        $auth = $sm->get('AuthService');
        /*
        //if not connected and controller isn't the index controller -> redirect to login page
        if(!$auth->hasIdentity() && $controller != 'Application\Controller\Index')
        {
            $router = $e->getRouter();
            $url = $router->assemble(array(),array('name','login'));

            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
        }*/
        return false;
    }

    public function initAcl(MvcEvent $e)
    {
        $acl = new \Zend\Permissions\Acl\Acl();
        $roles = include __DIR__ . '/config/modules.acl.roles.php';
        $allResources = array();
        foreach($roles as $role => $resources)
        {
            $role = new \Zend\Permissions\Acl\Role\GenericRole($role);
            $acl->addRole($role);
            $allResources = array_merge($resources,$allResources);

            //Resources
            foreach($resources as $resource)
            {
                if(!$acl->hasResource($resource))
                {
                    $acl->addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
                }
            }
            //Restrictions
            foreach($resources as $resource)
            {
                $acl->allow($role,$resource);
            }
        }

        //setting to view
        $e->getViewModel()->acl = $acl;
    }

    public function checkAcl(MvcEvent $e)
    {
        $matches = $e->getRouteMatch();
        $action = $matches->getParam('action');

        $route = $matches->getParam('controller').'\\'. $action;

        $e->getApplication()->getServiceManager()->get('AuthService')->getStorage()->read();
        $role = $e->getApplication()->getServiceManager()->get('AuthService')->getStorage()->getRole();
        if(isset($role))
        {
            $userRole = $role;
        }
        else
        {
            $userRole = 'guest';
        }
        if(!$e->getViewModel()->acl->hasResource($route)
           || !$e->getViewModel()->acl->isAllowed($userRole, $route))
        {
            $response = $e->getResponse();

            $response->getHeaders()->addHeaderLine('Location', $e->getRequest()->getBaseUrl() . '/404');
            $response->setStatusCode(401);
            header('Location: '.$e->getRouter()->assemble(array(),array('name'=>'login')),TRUE,301);
            die();
        }
    }
}
