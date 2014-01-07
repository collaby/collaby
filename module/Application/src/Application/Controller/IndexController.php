<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Document;

class IndexController extends ActionController {

   /**
    * Mapped as
    *    /
    */
   public function indexAction() {
      $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
      $model = new Document();
      $sql = $model->listLastDocuments();
      $st = $adapter->query($sql);
      $list = $st->execute();
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
    * Mapped as
    *   /signup
    */
   public function signupAction() {
      
   }

}
