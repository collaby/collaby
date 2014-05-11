<?php

return array(
    'di' => array(),
    'view_helpers' => array(
        'invokables' => array(
            'session' => 'Core\View\Helper\Session'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Log' => function ($sm) {
               $log = new Zend\Log\Logger();
               $writer = new Zend\Log\Writer\Stream('/tmp/log.txt');
               $log->addWriter($writer);

               return $log;
            },
        ),
    ),
);
