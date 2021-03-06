<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'login',
                    ),
                ),
            ),
            'register' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/register',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'register',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'offer' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/offer/[:id]',
                    'constraints' => array(
                        'id' => '[\%a-zA-Z0-9_\.-]{1,}'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'offer',
                    ),
                ),
            ),
            'customerIndex' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/customer/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Customer',
                        'action'     => 'index',
                    ),
                ),
            ),
            'customerOffers' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/customer/offers/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Customer',
                        'action'     => 'offers',
                    ),
                ),
            ),
            'customerFiles' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/customer/files/[:id]',
                    'constraints' => array(
                        'id' => '[0-9]{1,}'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Customer',
                        'action'     => 'files',
                    ),
                ),
            ),
            'getUserWithTokenWS' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/ws/getUserWithToken/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Ws',
                        'action'     => 'getUserWithToken',
                    ),
                ),
            ),
            'updateDiskSpaceWS' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/ws/updateDiskSpace/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Ws',
                        'action'     => 'updateDiskSpace',
                    ),
                ),
            ),
            'loginWs' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/ws/login/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Ws',
                        'action'     => 'login',
                    ),
                ),
            ),
            'captcha' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/captcha/[:id]',
                    'constraints' => array(
                        'id' => '[a-zA-Z0-9_\.-]{1,}'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Captcha',
                        'action'     => 'generate',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
            'Zend\Authentication\AuthenticationService' => 'AuthService',
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index'          => 'Application\Controller\IndexController',
            'Application\Controller\Captcha'        => 'Application\Controller\CaptchaController',
            'Application\Controller\Customer'       => 'Application\Controller\CustomerController',
            'Application\Controller\Ws'             => 'Application\Controller\WsController',
            'Application\Controller\Cronjob'        => 'Application\Controller\CronjobController',
            'Application\Controller\SeleniumTest'   => 'Application\Controller\SeleniumTestController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/flashMessage'     => __DIR__ . '/../view/layout/flashMessage.phtml',
            'layout/menuLeftAdmin'    => __DIR__ . '/../view/layout/menuLeftAdmin.phtml',
            'layout/menuLeftCustomer' => __DIR__ . '/../view/layout/menuLeftCustomer.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
                'cronroute' => array(
                    'options' => array(
                        'route'    => 'updateWorkers',
                        'defaults' => array(
                            'controller' => 'Application\Controller\Cronjob',
                            'action' => 'updateWorkers'
                        )
                    )
                ),
                'loginTest' => array(
                    'options' => array(
                        'route'    => 'loginTest',
                        'defaults' => array(
                            'controller' => 'Application\Controller\SeleniumTest',
                            'action' => 'loginTest'
                        )
                    )
                )
            )
        )
    )
);
