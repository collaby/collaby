<?php

namespace Application\Form;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Description of LoginFilter
 *
 * @author atila
 */
class LoginFilter implements InputFilterAwareInterface {
    
    protected $_inputFilter;
    
    public function getInputFilter() {
        if (! $this->_inputFilter) {
            $this->_inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $this->_inputFilter->add(
                $factory->createInput(array(
                    'name' => 'username',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim')
                    ),
                    'validators' => array(
                        array(
                            'name' => 'Regex',
                            'options' => array(
                                'pattern' => '/^[a-zA-Z][a-zA-Z0-9_]{0,19}$/',
                                'messages' => array(
                                    'regexNotMatch' => 'Username must start with a letter and contain only letters, numbers or _(undescore)'
                                )
                            )
                        ),
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 20
                            )
                        )
                    )
                ))
            );
            
            $this->_inputFilter->add(
                $factory->createInput(array(
                    'name' => 'password',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim')
                    )
                ))
            );
        }
        return $this->_inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Method not necessary.");
    }

}
