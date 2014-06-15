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
    public $offer_id;
    public $expire;
    public $nbr_of_files;
    public $space_used_in_bytes;

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
        $this->offer_id                 = (isset($data->offer_id)) ? $data->offer_id : null;
        $this->expire                   = (isset($data->expire)) ? $data->expire : null;
        $this->nbr_of_files             = (isset($data->nbr_of_files)) ? $data->nbr_of_files : null;
        $this->space_used_in_bytes      = (isset($data->space_used_in_bytes)) ? $data->space_used_in_bytes : null;
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
        $this->offer_id                 = (isset($data['offer_id'])) ? $data['offer_id'] : null;
        $this->expire                   = (isset($data['expire'])) ? $data['expire'] : null;
        $this->nbr_of_files             = (isset($data['nbr_of_files'])) ? $data['nbr_of_files'] : null;
        $this->space_used_in_bytes      = (isset($data['space_used_in_bytes'])) ? $data['space_used_in_bytes'] : null;
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
                'role'                  => $this->role,
                'offer_id'              => $this->offer_id,
                'expire'                => $this->expire,
                'nbr_of_files'          => $this->nbr_of_files,
                'space_used_in_bytes'   => $this->space_used_in_bytes
            );
            
            foreach($filterOut as $propertyName)
            {
                unset($array[$propertyName]);
            }
            return $array;
    }
}