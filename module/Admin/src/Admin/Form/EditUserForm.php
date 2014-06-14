<?php

namespace Admin\Form;

use Zend\Form\Element\Select;
use Zend\Form\Element;
use Zend\Form\Form;

class EditUserForm extends Form
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
                
        $this->add(array('name' => 'first_name',
                         'attributes'   => array(
                             'type'     => 'text',
                             'class'    => 'span2'
                         ),
                         'options'      => array(
                             'label'    => 'First Name'
                         )
            ));
        
        $this->add(array('name' => 'last_name',
                         'attributes'   => array(
                             'type'     => 'text'
                         ),
                         'options'      => array(
                             'label'    => 'Last Name'
                         )
            ));
        
        $this->add(array('name' => 'email',
                         'attributes'   => array(
                             'type'     => 'text'
                         ),
                         'options'      => array(
                             'label'    => 'E-mail'
                         )
            ));
                 
        $this->add(array('name' => 'phone',
                         'attributes'   => array(
                             'type'     => 'text'
                         ),
                         'options'      => array(
                             'label'    => 'Phone'
                         )
            ));
            
        $this->add(array('name' => 'password',
                         'attributes'   => array(
                             'type'     => 'password'
                         ),
                         'options'      => array(
                             'label'    => 'Password'
                         )
            ));

        $this->add(array('name' => 'role',
            'type'     => 'Zend\Form\Element\Select',
            'options'      => array(
                'value_options' => array('Admin' => 'Admin','Customer' => 'Customer'),
                'label'    => 'role'
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
