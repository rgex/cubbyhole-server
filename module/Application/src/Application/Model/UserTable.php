<?php

namespace Application\Model;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
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

    public function getUserArray($id,$filterOut = array())
    {
        $row = $this->getUser($id);
        $user = new User();
        $user->exchangeRow($row);
        return $user->returnArray($filterOut);
    }
    
    public function insert($data)
    {
        $this->tableGateway->insert($data);
    }

    public function update($data,$where)
    {
        $this->tableGateway->update($data,$where);
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

    public function addDiskUsage($userId, $space)
    {
        $userRow = $this->getUser($userId);
        $user = new User();
        $user->exchangeRow($userRow);
        $data = $user->returnArray(array('count'));
        $data['space_used_in_bytes'] += $space;
        $this->tableGateway->update($data,array('id' => (int)$userId));
    }

    public function addFiles($userId, $nbrOfFiles)
    {
        $userRow = $this->getUser($userId);
        $user = new User();
        $user->exchangeRow($userRow);
        $data = $user->returnArray(array('count'));
        $data['nbr_of_files'] += $nbrOfFiles;
        $this->tableGateway->update($data,array('id' => (int)$userId));
    }

    public function count($condition = '1 = 1')
    {
        $this->condition = $condition;
        $row = $this->tableGateway->select(function (Select $select){
            $select->columns(array('count'=>new Expression('COUNT(id)')));
            $select->where($this->condition);
        });
        return $row->current()->count;
    }
    
}
