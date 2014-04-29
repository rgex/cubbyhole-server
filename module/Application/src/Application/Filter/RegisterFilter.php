<?php

namespace Application\Filter\RegisterFilter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class RegisterFilter implements InputFilterAwareInterface
{
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('Not used');
    }
    
    public function getInputFilter()
    {
        if(!$this->inputFilter)
        {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name'      => 'id',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'int')
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'      => 'firstName',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'ScriptTags'),
                    array('name' => 'ScriptTrim'),
                ),
                'validators' => array(
                    array(
                        'name'      => 'StringLength',
                        'options'   => array(
                            'min'   => 2,
                            'max'   => 40,
                        )
                    )
                )
            )));
            
        }
    }
}