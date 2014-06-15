<?php

namespace Application\Model;
use Zend\Db\Sql\Expression;
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

    public function getOffersForFormSelect()
    {
        $resultSet = $this->tableGateway->select();
        $res = array();
        foreach($resultSet as $row) {
            $res[$row->id] = $row->title;
        }
        return $res;
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
        $offer = new Offer();
        $offer->exchangeRow($row);
        return $offer->returnArray($filterOut);
    }
    
    public function insert($data)
    {
        $this->tableGateway->insert($data);
    }

    public function update($data,$where)
    {
        $this->tableGateway->update($data,$where);
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