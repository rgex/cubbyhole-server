<?php

namespace Application\Model;

class Offer
{
    public $id;
    public $position_priority;
    public $month_price;
    public $size_go;
    public $maximum_upload_speed;
    public $maximum_download_speed;
    public $date_creation;
    public $date_last_edit;
    public $title;
    public $short_description;
    public $long_description;

    public function exchangeRow($data)
    {
        $this->id                           = (isset($data->id)) ? $data->id : null;
        $this->position_priority            = (isset($data->position_priority)) ? strtolower($data->position_priority) : null;
        $this->month_price                  = (isset($data->month_price)) ? $data->month_price : null;
        $this->size_go                      = (isset($data->size_go)) ? $data->size_go : null;
        $this->maximum_upload_speed         = (isset($data->maximum_upload_speed)) ? $data->maximum_upload_speed : null;
        $this->maximum_download_speed       = (isset($data->maximum_download_speed)) ? $data->maximum_download_speed : null;
        $this->date_creation                = (isset($data->date_creation)) ? $data->date_creation : null;
        $this->date_last_edit               = (isset($data->date_last_edit)) ? $data->date_last_edit : null;
        $this->title                        = (isset($data->title)) ? $data->title : null;
        $this->short_description            = (isset($data->short_description)) ? $data->short_description : null;
        $this->long_description             = (isset($data->long_description)) ? $data->long_description : null;
    }

    public function exchangeArray(Array $data)
    {
        $this->id                           = (isset($data['id'])) ? $data['id'] : null;
        $this->position_priority            = (isset($data['position_priority'])) ? strtolower($data['position_priority']) : null;
        $this->month_price                  = (isset($data['month_price'])) ? $data['month_price'] : null;
        $this->size_go                      = (isset($data['size_go'])) ? $data['size_go'] : null;
        $this->maximum_upload_speed         = (isset($data['maximum_upload_speed'])) ? $data['maximum_upload_speed'] : null;
        $this->maximum_download_speed       = (isset($data['maximum_download_speed'])) ? $data['maximum_download_speed'] : null;
        $this->date_creation                = (isset($data['date_creation'])) ? $data['date_creation'] : null;
        $this->date_last_edit               = (isset($data['date_last_edit'])) ? $data['date_last_edit'] : null;
        $this->title                        = (isset($data['title'])) ? $data['title'] : null;
        $this->short_description            = (isset($data['short_description'])) ? $data['short_description'] : null;
        $this->long_description             = (isset($data['long_description'])) ? $data['long_description'] : null;
    }
    
    public function returnArray(Array $filterOut = array())
    {
            $array = array(
                'id'                        => $this->id,
                'position_priority'         => $this->position_priority,
                'month_price'               => $this->month_price,
                'size_go'                   => $this->size_go,
                'maximum_upload_speed'      => $this->maximum_upload_speed,
                'maximum_download_speed'    => $this->maximum_download_speed,
                'date_creation'             => $this->date_creation,
                'date_last_edit'            => $this->date_last_edit,
                'title'                     => $this->title,
                'short_description'         => $this->short_description,
                'long_description'          => $this->long_description
            );
            
            foreach($filterOut as $propertyName)
            {
                unset($array[$propertyName]);
            }
            return $array;
    }
}