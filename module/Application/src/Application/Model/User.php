<?php

namespace Application\Model;

class User
{
    public $id;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $phone;
    public $subscription_date;
    public $last_connection_date;
    public $subscription_ip;
    public $role;

    public function exchangeRow($data)
    {
        $this->id                       = (isset($data->id)) ? $data->id : null;
        $this->email                    = (isset($data->email)) ? strtolower($data->email) : null;
        $this->password                 = (isset($data->password)) ? $data->password : null;
        $this->first_name               = (isset($data->first_name)) ? $data->first_name : null;
        $this->last_name                = (isset($data->last_name)) ? $data->last_name : null;
        $this->phone                    = (isset($data->phone)) ? $data->phone : null;
        $this->subscription_date        = (isset($data->subscription_date)) ? $data->subscription_date : null;
        $this->last_connection_date     = (isset($data->last_connection_date)) ? $data->last_connection_date : null;
        $this->subscription_ip          = (isset($data->subscription_ip)) ? $data->subscription_ip : null;
        $this->role                     = (isset($data->role)) ? $data->role : null;
    }

    public function exchangeArray(Array $data)
    {
        $this->id                       = (isset($data['id'])) ? $data['id'] : null;
        $this->email                    = (isset($data['email'])) ? strtolower($data['email']) : null;
        $this->password                 = (isset($data['password'])) ? $data['password'] : null;
        $this->first_name               = (isset($data['first_name'])) ? $data['first_name'] : null;
        $this->last_name                = (isset($data['last_name'])) ? $data['last_name'] : null;
        $this->phone                    = (isset($data['phone'])) ? $data['phone'] : null;
        $this->subscription_date        = (isset($data['subscription_date'])) ? $data['subscription_date'] : null;
        $this->last_connection_date     = (isset($data['last_connection_date'])) ? $data['last_connection_date'] : null;
        $this->subscription_ip          = (isset($data['subscription_ip'])) ? $data['subscription_ip'] : null;
        $this->role                     = (isset($data['role'])) ? $data['role'] : null;
    }
    
    public function returnArray(Array $filterOut = array())
    {
            $array = array(
                'id'                    => $this->id,
                'email'                 => $this->email,
                'password'              => $this->password,
                'first_name'            => $this->first_name,
                'last_name'             => $this->last_name,
                'phone'                 => $this->phone,
                'subscription_date'     => $this->subscription_date,
                'last_connection_date'  => $this->last_connection_date,
                'subscription_ip'       => $this->subscription_ip,
                'role'                  => $this->role
            );
            
            foreach($filterOut as $propertyName)
            {
                unset($array[$propertyName]);
            }
            return $array;
    }
}