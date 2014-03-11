<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

/**
 * Description of UserController
 *
 * @author atila
 */
class UserController extends ActionController {

    /**
     * Mapped as
     *    /u/:username
     * @return \Zend\View\Model\ViewModel
     */
    public function viewAction() {
        $username = $this->params()->fromRoute('username', "");
        if (empty($username)) {
            $this->messages()->flashWarning('Username is required to access this page.');
            return $this->redirect()->toUrl('/');
        }
        
        $sm = $this->getServiceLocator();
        $userTable = $sm->get('Application\Model\UserTable');
        $user = $userTable->read($username);
        
        $documentTable = $sm->get('Application\Model\DocumentTable');
        $list = $documentTable->listLastDocuments();

        return new ViewModel(array(
            'user' => $user,
            'list' => $list
        ));
    }

}
