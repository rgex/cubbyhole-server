<?php

namespace Application\Model;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;

class OfferTable
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

    public function getBestOffers($n = 3)
    {
        $select = new Select();
        $select->order('position_priority DESC')->limit($n);
        $resultSet = $this->tableGateway->select($select);
        return $resultSet;
    }
    
    public function getOffer($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        return $row;
    }

    public function getOfferArray($id,$filterOut = array())
    {
        $row = $this->getOffer($id);
        $user = new Offer();
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
    
}