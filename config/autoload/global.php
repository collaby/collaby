<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
            => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'pgsql:host=localhost;dbname=zf2napratica',
    ),
    'acl' => array(
        'roles' => array(
            'visitante' => null,
            'redator' => 'visitante',
            'admin' => 'redator'
        ),
        'resources' => array(
            'Application\Controller\Index.index',
            'Application\Controller\Index.about',
            'Admin\Controller\Index.save',
            'Admin\Controller\Index.delete',
            'Admin\Controller\Auth.index',
            'Application\Controller\Auth.login',
            'Application\Controller\Auth.logout',
            'Application\Controller\Index.signup',
            'Application\Controller\Document.new',
            'Application\Controller\Document.edit',
            'Application\Controller\Document.export',
            'Application\Controller\Document.import',
        ),
        'privilege' => array(
            'visitante' => array(
                'allow' => array(
                    'Application\Controller\Index.index',
                    'Application\Controller\Index.about',
                    'Admin\Controller\Auth.index',
                    'Application\Controller\Auth.login',
                    'Application\Controller\Auth.logout',
                    'Application\Controller\Index.signup',
                    'Application\Controller\Document.new',
                    'Application\Controller\Document.edit',
                    'Application\Controller\Document.export',
                    'Application\Controller\Document.import',
                )
            ),
            'redator' => array(
                'allow' => array(
                    'Admin\Controller\Index.save',
                )
            ),
            'admin' => array(
                'allow' => array(
                    'Admin\Controller\Index.delete',
                )
            ),
        )
    )
);
