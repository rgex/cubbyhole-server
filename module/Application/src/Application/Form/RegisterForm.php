<?php

namespace Application\Form;

use Zend\Captcha\Image as CaptchaImage;
//use Zend\Form\Element;
use Zend\Form\Element\Captcha;
use Zend\Form\Form;

class RegisterForm extends Form
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
                
        $this->add(array('name' => 'firstName',
                         'attributes'   => array(
                             'type'     => 'text',
                             'class'    => 'span2'
                         ),
                         'options'      => array(
                             'label'    => 'First Name'
                         )
            ));
        
        $this->add(array('name' => 'lastName',
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
                   
       $this->add(array('name' => 'password2',
                         'attributes'   => array(
                             'type'     => 'password'
                         ),
                         'options'      => array(
                             'label'    => 'Retype Password'
                         )
            ));
       
       $captcha = new CaptchaImage();
       $captcha->setFont('./data/captcha/font/FreeSansBold.ttf');
       $captcha->setImgDir('./data/captcha');
       $captcha->setImgUrl('/captcha');
       
       $this->add(array('name' => 'captcha',
                        'type' => 'Zend\Form\Element\Captcha',
                         'attributes'   => array(
                             'name'     => 'captcha',
                             ),
                             'options'  => array(
                                 'label'    => 'Please proove you are a human',
                                 'captcha'  => $captcha 
                            )
            ));
      
       $this->add(array('name' => 'submit',
                         'attributes'   => array(
                             'type'     => 'submit',
                             'value'    => 'Register',
                             'class'    => 'btn btn-primary'
                         )
            ));
    }
}
