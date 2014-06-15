<?php

namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;

class TokenTable
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

    public function getTokenWithUserId($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('user_id' => $id));
        $row = $rowset->current();
        return $row;
    }

    public function getToken($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        return $row;
    }

    public function getWorkerArray($id,$filterOut = array())
    {
        $row = $this->getToken($id);
        $token = new Token();
        $token->exchangeRow($row);
        return $token->returnArray($filterOut);
    }
    
    public function insert($data)
    {
        $this->tableGateway->insert($data);
    }

    public function update($data,$where)
    {
        $this->tableGateway->update($data,$where);
    }

    public function getOrCreateToken($user_id)
    {
        $token = $this->getTokenWithUserId($user_id);
        if($token) {
            return $token->token;
        }
        else
        {
            $token = sha1(time().$user_id.rand(100000000,10000000000).'KGYUJGDSJDJSKDSJDSKJDS66754SDSDS67S5D7S6D5S65SDSD');
            $this->insert(array('user_id'   => $user_id,
                                'token'     => $token,
                                'expire'    => time()+365*24*60*60));
            return $token;
        }
    }

    public function getUserIdWithToken($token)
    {
        $rowset = $this->tableGateway->select(array('token' => $token));
        $row = $rowset->current();
        if(!$row)
            return null;
        return $row->user_id;
    }
    
}