<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Application\Form\Signup;
use Zend\View\Model\ViewModel;
use Application\Form\SignupFilter;

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
        
        $request = $this->getRequest();
        $sm = $this->getServiceLocator();
        $model = $sm->get('Application\Model\UserTable');
        
        if ($request->isPost()) {
            $inputFilter = new SignupFilter();
            $form->setInputFilter($inputFilter->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                
                $data['acl_roles_id'] = \Application\Service\Auth::DEFAULT_ROLE_ID;
                $data['real_name'] = $data['username'];
                
                $model->signup($data);
                $this->redirect()->toRoute('view-user', array('username' => $form->getInputFilter()->getValue('username')));
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

}
