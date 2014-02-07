<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Login extends Form {

    public function __construct() {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->add($this->_username());
        $this->add($this->_password());
        $this->add($this->_submit());
    }

    protected function _username() {
        $e = new Element\Text('username');
        $e->setAttribute("id", "username")
                ->setAttribute("class", "form-control input-lg")
                ->setAttribute("placeholder", "Username");
        
        return $e;
    }

    protected function _password() {
        $e = new Element\Password('password');
        $e->setAttribute("id", "password")
                ->setAttribute("class", "form-control input-lg")
                ->setAttribute("placeholder", "Password");
        
        return $e;
    }
    
    protected function _submit() {
        $e = new Element\Submit('submit');
        $e->setValue("Login")
                ->setAttribute("class", "btn btn-primary btn-block btn-lg");
        
        return $e;
    }
}
