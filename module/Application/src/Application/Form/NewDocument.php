<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Db\Sql\Select;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Description of NewDocument
 *
 * @author atila
 */
class NewDocument extends Form implements InputFilterProviderInterface {

   protected $tableTemplates;
   protected $document_type_id;

   public function __construct($tableTemplates, $document_type_id) {
      $this->setTableTemplates($tableTemplates);
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
              ->setLabel("Name")
              ->setAttribute("placeholder", "e.g. Exercise 1, List 2, Article about Math...")
              ->setAttribute("autofocus", "autofocus");

      return $e;
   }
   
   protected function _template() {
      $e = new Element\Radio('original_template_id');
      $e->setLabel('Template');
      $e->setAttribute("id", "original_template_id");
      $select = new Select();
      $select->from($this->getTableTemplates()->getTableGateway()->getTable());
      $select->columns(array('id', 'description'));
      $select->where(array('document_type_id' => $this->document_type_id));
      $rs = $this->getTableTemplates()->getTableGateway()->selectWith($select);
      $options = array();
      foreach ($rs as $item) {
         $options[$item->id] = $item->description;
      }
      $e->setValueOptions($options);
      // TODO: set default value dynamically!
      $e->setValue("1");
      return $e;
   }
   
   protected function _submit() {
        $e = new Element\Submit('submit');
        $e->setValue("Continue")
                ->setAttribute("class", "btn btn-primary pull-right");
        
        return $e;
    }
    
    public function getInputFilterSpecification() {
      return array(
          'name' => array(
              'required' => true,
              'filters'  => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
              ),
              'validators' => array (
                  array(
                    'name'    => 'StringLength',
                    'options' => array(
                       'encoding' => 'UTF-8',
                       'min'      => 1,
                       'max'      => 200,
                    ),
                 ),
              )
          ),
      );
   }

   public function getTableTemplates() {
       return $this->tableTemplates;
    }

    public function setTableTemplates($tableTemplates) {
       $this->tableTemplates = $tableTemplates;
    }
}
