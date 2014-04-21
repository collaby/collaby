<?php

namespace Application;

use Application\Service\Auth;

// module/Application/conﬁg/module.config.php:

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/[page/:page]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                        'module'     => 'application',
                    ),
                ),
            ),
            'about' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/about',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'about',
                        'module'     => 'application',
                    ),
                ),
            ),
            'login' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Auth',
                        'action'     => 'login',
                        'module'     => 'application',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Auth',
                        'action'     => 'logout',
                        'module'     => 'application',
                    ),
                ),
            ),
            'signup' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/signup',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'signup',
                        'module'     => 'application',
                    ),
                ),
            ),
            'new-document' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/new[/:type]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Document',
                        'action'     => 'new',
                        'module'     => 'application',
                    ),
                ),
            ),
            'edit-document' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/d/:id',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Document',
                        'action'     => 'edit',
                        'module'     => 'application',
                    ),
                ),
            ),
            'export-document' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/d/:id/export[/:type]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Document',
                        'action'     => 'export',
                        'module'     => 'application',
                    ),
                ),
            ),
            'import-document' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/import',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Document',
                        'action'     => 'import',
                        'module'     => 'application',
                    ),
                ),
            ),
            'clone-document' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/clone/:id',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Document',
                        'action'     => 'clone',
                        'module'     => 'application',
                    ),
                ),
            ),
            'preview-document' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/preview/:id',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Document',
                        'action'     => 'preview',
                        'module'     => 'application',
                    ),
                ),
            ),
            'view-user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/u/:username',
                    'defaults' => array(
                        'controller' => 'Application\Controller\User',
                        'action'     => 'view',
                        'module'     => 'application',
                    ),
                ),
            ),
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        'controller'    => 'Index',
                        'action'        => 'index',
                        '__NAMESPACE__' => 'Application\Controller',
                        'module'     => 'application'
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
                        'child_routes' => array( //permite mandar dados pela url 
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'Session' => function($sm) {
                return new \Zend\Session\Container('ZF2napratica');
            },
            'Application\Service\Auth' => function($sm) {
                $dbAdapter = $sm->get('DbAdapter');
                return new Auth($dbAdapter);
            },
        ),
    ),
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
                'text_domain' => __NAMESPACE__,
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Auth' => 'Application\Controller\AuthController',
            'Application\Controller\Document' => 'Application\Controller\DocumentController',
            'Application\Controller\User' => 'Application\Controller\UserController',
            'Application\Controller\Account' => 'Application\Controller\AccountController',
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
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
