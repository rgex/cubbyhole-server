<?php

namespace Admin\Form;

use Zend\Form\Element\Select;
use Zend\Form\Element;
use Zend\Form\Form;

class EditWorkerForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Register');
        
        $this->setAttribute('method','POST');
        
        $this->add(array('name' => 'id',
                         'attributes'   => array(
                             'type'     => 'hidden'
                         )
            ));
                
        $this->add(array('name' => 'location',
                         'attributes'   => array(
                             'type'     => 'text',
                         ),
                         'options'      => array(
                             'label'    => 'Location'
                         )
            ));

        $this->add(array('name' => 'ws1',
            'attributes'   => array(
                'type'     => 'text',
            ),
            'options'      => array(
                'label'    => 'WS1'
            )
        ));

        $this->add(array('name' => 'ws2',
            'attributes'   => array(
                'type'     => 'text',
            ),
            'options'      => array(
                'label'    => 'WS2'
            )
        ));


       $this->add(array('name' => 'save',
                         'attributes'   => array(
                             'type'     => 'submit',
                             'value'    => 'Save',
                             'class'    => 'btn btn-primary saveBtn'
                         )
            ));
    }
}
