<?php

namespace Admin\Form;

use Zend\Form\Element\Select;
use Zend\Form\Element;
use Zend\Form\Form;

class EditOfferForm extends Form
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
                
        $this->add(array('name' => 'position_priority',
                         'attributes'   => array(
                             'type'     => 'text',
                             'class'    => 'smallInput'
                         ),
                         'options'      => array(
                             'label'    => 'Priority-position',
                             'class'    => 'smallInput'
                         )
            ));
        
        $this->add(array('name' => 'month_price',
                         'attributes'   => array(
                             'type'     => 'text',
                             'class'    => 'smallInput'
                         ),
                         'options'      => array(
                             'label'    => 'Price/month'
                         )
            ));
        
        $this->add(array('name' => 'size_go',
                         'attributes'   => array(
                             'type'     => 'text',
                             'class'    => 'smallInput'
                         ),
                         'options'      => array(
                             'label'    => 'Size'
                         )
            ));
                 
        $this->add(array('name' => 'maximum_upload_speed',
                         'attributes'   => array(
                             'type'     => 'text',
                             'class'    => 'smallInput'
                         ),
                         'options'      => array(
                             'label'    => 'Max. upload speed'
                         )
            ));

        $this->add(array('name' => 'maximum_download_speed',
            'attributes'   => array(
                'type'     => 'text',
                'class'    => 'smallInput'
            ),
            'options'      => array(
                'label'    => 'Max. download speed'
            )
        ));

        $this->add(array('name' => 'title',
                        'attributes'   => array(
                            'type'     => 'text'
                        ),
                        'options'      => array(
                            'label'    => 'Title'
                        )
        ));

        $this->add(array('name' => 'short_description',
            'type'     => 'Zend\Form\Element\Textarea',
            'attributes'   => array(
                'class'    => 'smallTextarea'
            ),
            'options'      => array(
                'label'    => 'Short Description'
            )
        ));

        $this->add(array('name' => 'long_description',
            'type'     => 'Zend\Form\Element\Textarea',
            'attributes'   => array(
                'class'    => 'normalTextarea'
            ),
            'options'      => array(
                'label'    => 'Long Description'
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
