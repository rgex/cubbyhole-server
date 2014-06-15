<?php

namespace Application\Model;

class Token
{
    public $id;
    public $user_id;
    public $token;
    public $expire;

    public function exchangeRow($data)
    {
        $this->id                           = (isset($data->id)) ? $data->id : null;
        $this->user_id                      = (isset($data->user_id)) ? strtolower($data->user_id) : null;
        $this->token                        = (isset($data->token)) ? $data->token : null;
        $this->expire                       = (isset($data->expire)) ? $data->expire : null;
    }

    public function exchangeArray(Array $data)
    {
        $this->id                           = (isset($data['id'])) ? $data['id'] : null;
        $this->user_id                      = (isset($data['user_id'])) ? strtolower($data['user_id']) : null;
        $this->token                        = (isset($data['token'])) ? $data['token'] : null;
        $this->expire                       = (isset($data['expire'])) ? $data['expire'] : null;
    }
    
    public function returnArray(Array $filterOut = array())
    {
            $array = array(
                'id'                        => $this->id,
                'user_id'                   => $this->user_id,
                'token'                     => $this->token,
                'expire'                    => $this->expire
            );
            
            foreach($filterOut as $propertyName)
            {
                unset($array[$propertyName]);
            }
            return $array;
    }
}