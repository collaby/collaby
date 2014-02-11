<?php

namespace Admin;

// module/Admin/conﬁg/module.config.php:
return array(
    'controllers' => array(//add module controllers
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Dashboard' => 'Admin\Controller\DashboardController',
            'Admin\Controller\Template' => 'Admin\Controller\TemplateController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dashboard' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Dashboard',
                        'action' => 'index',
                        'module' => 'admin'
                    )
                )
            ),
            'dashboard_template' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/template[/:action[/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Template',
                        'action' => 'index',
                        'module' => 'admin'
                    )
                )
            ),
            'admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                        'module' => 'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'child_routes' => array(//permite mandar dados pela url
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
    //ou adicionar no array do module.config.php (ou outro config)
    'service_manager' => array(
        'factories' => array(
        )
    ),
);
