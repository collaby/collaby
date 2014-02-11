<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

/**
 * Description of Template
 *
 * @author atila
 */
class Template extends Form {
    
    public function __construct() {
        parent::__construct('template');
        $this->setAttribute('method', 'post');
        $this->add($this->_description());
        $this->add($this->_content());
        $this->add($this->_submit());
    }
    
    protected function _description() {
        $e = new Element\Text('description');
        $e->setLabel('Description:')
                ->setAttribute("id", "description")
                ->setAttribute("class", "form-control")
                ->setAttribute('autofocus', 'autofocus');
        
        return $e;
    }
    
    protected function _content() {
        $e = new Element\Hidden('content');
        $e->setAttribute('id', 'content');
        return $e;
    }
    
    protected function _submit() {
        $e = new Element\Submit('submit');
        $e->setValue("Save")
                ->setAttribute("class", "btn btn-primary pull-right");
        
        return $e;
    }
}
