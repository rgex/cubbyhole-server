<?php

namespace Application\Form;

use Zend\Captcha\Image as CaptchaImage;

use Zend\Form\Element\Captcha;
use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Login');
        
        $this->setAttribute('method','POST');

        
        $this->add(array('name' => 'email',
                         'attributes'   => array(
                             'type'     => 'text'
                         ),
                         'options'      => array(
                             'label'    => 'E-mail'
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
        
        $this->add(array('name' => 'submit',
                         'attributes'   => array(
                             'type'     => 'submit',
                             'value'    => 'Login',
                             'class'    => 'btn btn-primary'
                         )
            ));
    }
}
