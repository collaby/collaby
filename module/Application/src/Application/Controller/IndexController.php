<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

class IndexController extends ActionController {

    /**
     * Mapped as
     *    /
     */
    public function indexAction() {
        /* $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
          $model = new Document();
          $sql = $model->listLastDocuments();
          $st = $adapter->query($sql);
          $list = $st->execute(); */

        $sm = $this->getServiceLocator();
        $model = $sm->get('Application\Model\DocumentTable');
        $list = $model->listLastDocuments();

        return new ViewModel(array(
            'list' => $list
        ));
    }

    /**
     * Mapped as
     *   /about
     */
    public function aboutAction() {
        // static about page
    }

    /**
     * @deprecated use Account#signup
     */
    public function signupAction() {
        
    }

}
