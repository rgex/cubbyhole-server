<?php

namespace Admin\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;

class EditUserFilter implements InputFilterAwareInterface
{
    
    public function __construct(Adapter $adapter){
        $this->dbAdapter = $adapter;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('Not used');
    }
     
    public function getInputFilter()
    {
        if(!isset($this->inputFilter))
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
                'name'      => 'first_name',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
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
            
            $inputFilter->add($factory->createInput(array(
                'name'      => 'last_name',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
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
            
            $inputFilter->add($factory->createInput(array(
                'name'      => 'email',
                'required'  => true,
                'validators' => array(
                    array(
                        'name' => 'regex',
                        'options' => array(
                            'pattern' => '/[A-Za-z0-9-_]{1,}@[A-Za-z0-9-]{2,}\.[A-Za-z]{2,20}/',
                            'message' => 'The format of the email is incorrect'
                        )
                    )
                )
            )));
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}