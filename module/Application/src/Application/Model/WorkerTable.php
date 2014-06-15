<?php

namespace Application\Model;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;

class WorkerTable
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
    
    public function getWorker($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        return $row;
    }

    public function getWorkerArray($id,$filterOut = array())
    {
        $row = $this->getWorker($id);
        $worker = new Worker();
        $worker->exchangeRow($row);
        return $worker->returnArray($filterOut);
    }
    
    public function insert($data)
    {
        $this->tableGateway->insert($data);
    }

    public function update($data,$where)
    {
        $this->tableGateway->update($data,$where);
    }

    public function getActiveWorker()
    {
        $select = new Select(array('status' => 'up'));
        $select->order('last_update DESC')->limit(1);
        $resultSet = $this->tableGateway->select($select);
        return $resultSet->current();
    }
    
}