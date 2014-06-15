<?php

namespace Application\Helper;

use Application\Model\WorkerTable;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Http\Client;
use Zend\Http\Request;

class WorkerHelper
{
    public function __construct(WorkerTable $workerTable)
    {
        $this->workerTable = $workerTable;
    }

    public function createUser($id)
    {
        $url = $this->workerTable->getActiveWorker()->ws1.'createUser';
        $fields = array(
            'masterKey'  => 'SsdsdSD77DD544FF',
            'userId'   => $id
        );

        $fields_string = '';
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
        return $result;
    }

    public function pingWorker($url)
    {
        //open connection
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $url.'getSanSpace');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
        return $result;
    }
}