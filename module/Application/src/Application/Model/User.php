<?php

namespace Application\Model;

class User
{
    public $id;
    public $email;
    public $password;
    public $firstName;
    public $lastName;
    public $phone;
    public $subscriptionDate;
    public $lastConnectionDate;
    public $subscriptionIp;
    public $privilege;
    
    public function exchangeArray($data)
    {
        $this->id                   = (isset($data['id'])) ? $data['id'] : null;
        $this->email                = (isset($data['email'])) ? $data['email'] : null;
        $this->password             = (isset($data['password'])) ? $data['password'] : null; //TODO : hash password
        $this->firstName            = (isset($data['firstName'])) ? $data['firstName'] : null;
        $this->lastName             = (isset($data['lastName'])) ? $data['lastName'] : null;
        $this->phone                = (isset($data['phone'])) ? $data['phone'] : null;
        $this->subscriptionDate     = (isset($data['subscriptionDate'])) ? $data['subscriptionDate'] : null;
        $this->lastConnectionDate   = (isset($data['lastConnectionDate'])) ? $data['lastConnectionDate'] : null;
        $this->subscriptionIp       = (isset($data['subscriptionIp'])) ? $data['subscriptionIp'] : null;
        $this->privilege            = (isset($data['privilege'])) ? $data['privilege'] : null;
    }
    
    public function returnArray(Array $filterOut)
    {
            $array = array(
                'id'                    => $this->id,
                'email'                 => $this->email,
                'password'              => $this->password,
                'first_name'            => $this->firstName,
                'last_name'             => $this->lastName,
                'phone'                 => $this->phone,
                'subscription_date'     => $this->subscriptionDate,
                'last_connection_date'  => $this->lastConnectionDate,
                'subscription_ip'       => $this->subscriptionIp,
                'privilege'             => $this->privilege
            );
            
            foreach($filterOut as $propertyName)
            {
                unset($array[$propertyName]);
            }
            return $array;
    }
}