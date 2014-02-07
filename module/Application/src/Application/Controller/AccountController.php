<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Application\Form\Signup;
use Zend\View\Model\ViewModel;

/**
 * Description of AccountController
 *
 * @author atila
 */
class AccountController extends ActionController {

    /**
     * Mapped as
     *  /signup
     * @return \Zend\View\Model\ViewModel
     */
    public function signupAction() {
        $form = new Signup();
        return new ViewModel(array(
            'form' => $form
        ));
    }

}
