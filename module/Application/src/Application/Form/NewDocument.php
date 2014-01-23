<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

/**
 * Description of NewDocument
 *
 * @author atila
 */
class NewDocument extends Form {

   protected $table;
   protected $document_type_id;

   public function __construct($table, $document_type_id) {
      $this->setTable($table);
      $this->document_type_id = $document_type_id;
      parent::__construct('new-document');
      $this->setAttribute('method', 'post');
      $this->setAttribute('role', 'form');
      $this->add($this->_name());
      $this->add($this->_template());
      $this->add($this->_submit());
   }

   protected function _name() {
      $e = new Element\Text('name');
      $e->setAttribute("id", "name")
              ->setAttribute("class", "form-control")
              ->setLabel("Name");

      return $e;
   }
   
   protected function _template() {
      $e = new Element\Radio('original_template_id');
      $e->setLabel('Template');
      $e->setAttribute("id", "original_template_id");
      $rs = $this->getTable()->getTableGateway()->select(array('document_type_id' => $this->document_type_id));
      $options = array();
      foreach ($rs as $item) {
         $options[$item->id] = $item->description;
      }
      $e->setValueOptions($options);
      return $e;
   }
   
   protected function _submit() {
        $e = new Element\Submit('submit');
        $e->setValue("Continue")
                ->setAttribute("class", "btn btn-primary");
        
        return $e;
    }
    public function getTable() {
       return $this->table;
    }

    public function setTable($table) {
       $this->table = $table;
    }
}
