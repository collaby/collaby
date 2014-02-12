<?php

namespace Application\Form;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Description of SignupFilter
 *
 * @author atila
 */
class SignupFilter implements InputFilterAwareInterface {
    
    protected $_inputFilter;


    public function getInputFilter() {
        if (! $this->_inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add(
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
            
            $inputFilter->add(
                $factory->createInput(array(
                    'name' => 'password',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim')
                    )
                ))
            );
            
            $inputFilter->add(
                $factory->createInput(array(
                    'name' => 'email',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                        array('name' => 'StringToLower'),
                    ),
                    'validators' => array(
                        // http://zend-framework-community.634137.n4.nabble.com/ZF2-How-to-validate-a-password-and-email-in-zend-framework-2-td4657533.html#d1350024340321-169
                        array(
                            'name' => 'EmailAddress',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => '5',
                                'max' => '150'
                            )
                        )
                    )
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
