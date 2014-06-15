<?php

namespace Application\Model;

class Worker
{
    public $id;
    public $count;
    public $location;
    public $ws1;
    public $ws2;
    public $free_space_bytes;
    public $used_space_bytes;
    public $last_update;
    public $date_creation;
    public $status;

    public function exchangeRow($data)
    {
        $this->id                           = (isset($data->id)) ? $data->id : null;
        $this->count                        = (isset($data->count)) ? $data->count : null;
        $this->location                     = (isset($data->location)) ? strtolower($data->location) : null;
        $this->ws1                          = (isset($data->ws1)) ? $data->ws1 : null;
        $this->ws2                          = (isset($data->ws2)) ? $data->ws2 : null;
        $this->free_space_bytes             = (isset($data->free_space_bytes)) ? $data->free_space_bytes : null;
        $this->used_space_bytes             = (isset($data->used_space_bytes)) ? $data->used_space_bytes : null;
        $this->last_update                  = (isset($data->last_update)) ? $data->last_update : null;
        $this->date_creation                = (isset($data->date_creation)) ? $data->date_creation : null;
        $this->status                       = (isset($data->status)) ? $data->status : null;
    }

    public function exchangeArray(Array $data)
    {
        $this->id                           = (isset($data['id'])) ? $data['id'] : null;
        $this->count                        = (isset($data['count'])) ? $data['count'] : null;
        $this->location                     = (isset($data['location'])) ? strtolower($data['location']) : null;
        $this->ws1                          = (isset($data['ws1'])) ? $data['ws1'] : null;
        $this->ws2                          = (isset($data['ws2'])) ? $data['ws2'] : null;
        $this->free_space_bytes             = (isset($data['free_space_bytes'])) ? $data['free_space_bytes'] : null;
        $this->used_space_bytes             = (isset($data['used_space_bytes'])) ? $data['used_space_bytes'] : null;
        $this->last_update                  = (isset($data['last_update'])) ? $data['last_update'] : null;
        $this->date_creation                = (isset($data['date_creation'])) ? $data['date_creation'] : null;
        $this->status                       = (isset($data['status'])) ? $data['status'] : null;
    }
    
    public function returnArray(Array $filterOut = array())
    {
            $array = array(
                'id'                        => $this->id,
                'count'                     => $this->count,
                'location'                  => $this->location,
                'ws1'                       => $this->ws1,
                'ws2'                       => $this->ws2,
                'free_space_bytes'          => $this->free_space_bytes,
                'used_space_bytes'          => $this->used_space_bytes,
                'last_update'               => $this->last_update,
                'date_creation'             => $this->date_creation,
                'status'                    => $this->status
            );
            
            foreach($filterOut as $propertyName)
            {
                unset($array[$propertyName]);
            }
            return $array;
    }
}