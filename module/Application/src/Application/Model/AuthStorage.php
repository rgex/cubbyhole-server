<?php

namespace Application\Model;

use Zend\Authentication\Storage; 

class AuthStorage extends Storage\Session
{
    public $role;
    
    public $id;
    
    public $firstName;
    
    public $lastName;
    
    // Override
    public function write($contents)
    {
        parent::write($contents);
    }
    // Override
    public function read()
    {
        $contents = parent::read();

        if(isset($contents->role))
            $this->role = $contents->role;

        if(isset($contents->id))
            $this->id = $contents->id;

        if(isset($contents->first_name))
            $this->firstName = $contents->first_name;

         if(isset($contents->last_name))
            $this->lastName = $contents->last_name;

        return $contents;
    }
    
    public function getRole()
    {
        return $this->role;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getLastName()
    {
        return $this->lastName;
    }
    
    public function getFirstName()
    {
        return $this->firstName;
    }
}
