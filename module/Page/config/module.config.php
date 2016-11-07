<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Page;

return array(
    'controllers' => array(
        'invokables' => array(
            'Page\Controller\User' => 'Page\Controller\UserController'
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/Users[/:action]',
                    'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                    'defaults' => array(
                        'controller' => 'Page\Controller\User',
                        'action' => 'index',
                    ),
                ),
            ),
            'signup' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/SignUp',
                    'defaults' => array(
                        'controller' => 'Page\Controller\User',
                        'action' => 'signup',
                    ),
                ),
            ),
            'signin' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/SignIn',
                    'defaults' => array(
                        'controller' => 'Page\Controller\User',
                        'action' => 'signin',
                    ),
                ),
            ),
            'signout' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/SignOut',
                    'defaults' => array(
                        'controller' => 'Page\Controller\User',
                        'action' => 'signout',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'signup' => __DIR__ . '/../view',
        ),
    ),
);
