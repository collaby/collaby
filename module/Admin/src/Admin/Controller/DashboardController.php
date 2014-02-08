<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

/**
 * Description of DashboardController
 *
 * @author atila
 */
class DashboardController extends ActionController {
    
    public function indexAction() {
        return new ViewModel(array());
    }
}
