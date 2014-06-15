<?php

namespace Admin\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;

class EditWorkerFilter implements InputFilterAwareInterface
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
                'name'      => 'location',
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
                            'max'   => 150,
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'      => 'ws1',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Uri'
                    ),
                    array(
                        'name'      => 'StringLength',
                        'options'   => array(
                            'min'   => 2,
                            'max'   => 250,
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'      => 'ws2',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Uri'
                    ),
                    array(
                        'name'      => 'StringLength',
                        'options'   => array(
                            'min'   => 2,
                            'max'   => 250,
                        )
                    )
                )
            )));
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}