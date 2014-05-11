<?php

namespace Admin\Form;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Description of TemplateFilter
 *
 * @author atila
 */
class TemplateFilter implements InputFilterAwareInterface {
    
    protected $_inputFilter;
    
    public function getInputFilter() {
        if (! $this->_inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add(
                $factory->createInput(array(
                    'name' => 'description',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim')
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 50
                            )
                        )
                    )
                ))
            );
            
            $inputFilter->add(
                $factory->createInput(array(
                    'name' => 'content',
                    'required' => true,
                ))
            );
            
            $this->_inputFilter = $inputFilter;
        }
        return $this->_inputFilter;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Method not necessary.");
    }
}
