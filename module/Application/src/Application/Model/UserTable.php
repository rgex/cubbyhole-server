<?php

namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;

class UserTable
{
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getUser($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        return $row;
    }
    
    public function insert($data)
    {
        $this->tableGateway->insert($data);
    }
    
    public function login($email, $password)
    {
        $rowset = $this->tableGateway->select(array('email' => strtolower($email)));
        $row = $rowset->current();
        $bcrypt = new Bcrypt();
        if($row)
        {
            if($bcrypt->verify($password, $row->password))
                return $row;
            else
                return null;
        }
        else
        {
            return null;
        }
    }
    
}