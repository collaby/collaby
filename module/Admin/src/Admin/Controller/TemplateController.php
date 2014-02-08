<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

/**
 * Description of TemplateController
 *
 * @author atila
 */
class TemplateController extends ActionController {
    
    public function indexAction() {
        $sm = $this->getServiceLocator();
        $model = $sm->get('Admin\Model\AdminTemplateTable');
        $list = $model->listAll();
        
        return new ViewModel(array(
            'list' => $list
        ));
    }
}
