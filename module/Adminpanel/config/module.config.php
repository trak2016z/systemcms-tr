<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Adminpanel;

return array(
    'controllers' => array(
        'invokables' => array(
            'Adminpanel\Controller\Adminpanel' => 'Adminpanel\Controller\AdminpanelController',
            'Adminpanel\Controller\User' => 'Adminpanel\Controller\UserController',
            'Adminpanel\Controller\Group' => 'Adminpanel\Controller\GroupController',
            'Adminpanel\Controller\News' => 'Adminpanel\Controller\NewsController',
            'Adminpanel\Controller\Comment' => 'Adminpanel\Controller\CommentController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'adminpanel' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/AdminPanel[/:action]',
                    'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                    'defaults' => array(
                        'controller' => 'Adminpanel\Controller\Adminpanel',
                        'action' => 'index',
                    ),
                ),
            ),
            'adminuser' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/AdminPanel/User[/:action]',
                    'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                    'defaults' => array(
                        'controller' => 'Adminpanel\Controller\User',
                        'action' => 'index',
                    ),
                ),
            ),
            'admingroup' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/AdminPanel/Group[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9][0-9]*',
                     ),
                    'defaults' => array(
                        'controller' => 'Adminpanel\Controller\Group',
                        'action' => 'index',
                    ),
                ),
            ),
            'adminnews' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/AdminPanel/News[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9][0-9]*',
                     ),
                    'defaults' => array(
                        'controller' => 'Adminpanel\Controller\News',
                        'action' => 'index',
                    ),
                ),
            ),
            'admincomment' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/AdminPanel/Comment[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9][0-9]*',
                     ),
                    'defaults' => array(
                        'controller' => 'Adminpanel\Controller\Comment',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        /*'template_map' => array(
            //'layout/layout'           => __DIR__ . '/../view/layout/layout_admin.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),*/
        'template_path_stack' => array(
            'adminpanel' => __DIR__ . '/../view',
        ),
    ),
);
