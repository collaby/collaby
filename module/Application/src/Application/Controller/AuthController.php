<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Form\Login;

/**
 * 
 */
class AuthController extends ActionController {

    /**
     * Faz o login do usuário
     * @return void
     */
    public function loginAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $service = $this->getService('Application\Service\Auth');
            try {
                $auth = $service->authenticate(
                        array('username' => $data['username'], 'password' => $data['password'])
                );
                $this->messages()->flashSuccess('Login Successful.');
                return $this->redirect()->toUrl('/');
            } catch (\Exception $e) {
                $this->messages()->error($e->getMessage());
            }
            
        }
        $form = new Login();
        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * Faz o logout do usuário
     * @return void
     */
    public function logoutAction() {
        $service = $this->getService('Application\Service\Auth');
        $auth = $service->logout();
        return $this->redirect()->toUrl('/');
    }

}
