<?php

namespace Application\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Register');
        $this->setAttribute('method','post');
        
        $this->add(array('name' => 'id',
                         'attributes' => array(
                             'type' => 'hidden'
                         )
            ));
                
        $this->add(array('name' => 'firstName',
                         'attributes' => array(
                             'type' => 'text'
                         ),
                         'options' => array(
                             'label' => 'First Name'
                         )
            ));
        
        $this->add(array('name' => 'lastName',
                         'attributes' => array(
                             'type' => 'text'
                         ),
                         'options' => array(
                             'label' => 'Last Name'
                         )
            ));
        
        $this->add(array('name' => 'email',
                         'attributes' => array(
                             'type' => 'text'
                         ),
                         'options' => array(
                             'label' => 'E-mail'
                         )
            ));
                 
        $this->add(array('name' => 'phone',
                         'attributes' => array(
                             'type' => 'text'
                         ),
                         'options' => array(
                             'label' => 'Phone'
                         )
            ));
            
        $this->add(array('name' => 'password1',
                         'attributes' => array(
                             'type' => 'text'
                         ),
                         'options' => array(
                             'label' => 'Password'
                         )
            ));
                   
       $this->add(array('name' => 'password2',
                         'attributes' => array(
                             'type' => 'text'
                         ),
                         'options' => array(
                             'label' => 'Retype Password'
                         )
            ));
            
       $this->add(array('name' => 'submit',
                         'attributes' => array(
                             'type' => 'submit',
                             'value' => 'Register'
                         )
            ));
    }
}
