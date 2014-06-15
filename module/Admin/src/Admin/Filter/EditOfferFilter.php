<?php

namespace Admin\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;

class EditOfferFilter implements InputFilterAwareInterface
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
                'name'      => 'position_priority',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'Digits')
                ),
                'validators' => array(
                    array(
                        'name'      => 'StringLength',
                        'options'   => array(
                            'min'   => 1
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'      => 'month_price',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'Digits')
                ),
                'validators' => array(
                    array(
                        'name'      => 'StringLength',
                        'options'   => array(
                            'min'   => 1
                        )
                    )
                )
            )));


            $inputFilter->add($factory->createInput(array(
                'name'      => 'size_go',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'Digits')
                ),
                'validators' => array(
                    array(
                        'name'      => 'StringLength',
                        'options'   => array(
                            'min'   => 1
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'      => 'maximum_upload_speed',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'Digits')
                ),
                'validators' => array(
                    array(
                        'name'      => 'StringLength',
                        'options'   => array(
                            'min'   => 1
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'      => 'maximum_download_speed',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'Digits')
                ),
                'validators' => array(
                    array(
                        'name'      => 'StringLength',
                        'options'   => array(
                            'min'   => 1
                        )
                    )
                )
            )));


            $inputFilter->add($factory->createInput(array(
                'name'      => 'title',
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
                'name'      => 'short_description',
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
                            'max'   => 250,
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'      => 'long_description',
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
                            'max'   => 5000,
                        )
                    )
                )
            )));
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}