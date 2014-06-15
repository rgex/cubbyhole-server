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
            'adminUser' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/user/',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\User',
                        'action'     => 'index',
                    ),
                ),
            ),
            'editUser' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/admin/user/edit/[:id]',
                    'constraints' => array(
                        'id' => '[0-9]{1,}'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\User',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'adminOffer' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/offer/',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Offer',
                        'action'     => 'index',
                    ),
                ),
            ),
            'editOffer' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/admin/offer/edit/[:id]',
                    'constraints' => array(
                        'id' => '[0-9]{1,}'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Offer',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'newOffer' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/admin/offer/new',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Offer',
                        'action'     => 'new',
                    ),
                ),
            ),
            'adminWorker' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/worker/',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Worker',
                        'action'     => 'index',
                    ),
                ),
            ),
            'editWorker' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/admin/worker/edit/[:id]',
                    'constraints' => array(
                        'id' => '[0-9]{1,}'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Worker',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'newWorker' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/admin/worker/new',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Worker',
                        'action'     => 'new',
                    ),
                ),
            ),
            'stats' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/stats/',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Stats',
                        'action'     => 'index',
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
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../../Application/language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index'    => 'Admin\Controller\IndexController',
            'Admin\Controller\User'     => 'Admin\Controller\UserController',
            'Admin\Controller\Offer'     => 'Admin\Controller\OfferController',
            'Admin\Controller\Worker'     => 'Admin\Controller\WorkerController',
            'Admin\Controller\Stats'     => 'Admin\Controller\StatsController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../../Application/view/layout/layout.phtml',
            'layout/flashMessage'     => __DIR__ . '/../../Application/view/layout/flashMessage.phtml',
            'application/index/index' => __DIR__ . '/../../Application/view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'             => __DIR__ . '/../../Application/view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
