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

        return new ViewModel(array(
            'username' => $username
        ));
    }

}
