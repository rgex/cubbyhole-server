<?php

namespace Application\Helper;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class TableHelper
{

    private $params  = array(); // unsafe !!!
    private $options = array(); // safe

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->params = $_GET;
    }

    public function getUrl(Array $param)
    {
        $newParams = array_merge($this->params,$param);
        $payload = '';
        $separator ='?';
        foreach($newParams as $key=>$field)
        {
            $payload .= $separator.$key.'='.$field;
            $separator ='&';
        }
        return $payload;
    }

    public function dataFormatter($field,$formatterType)
    {
        switch($formatterType)
        {
            case 'dateFromTimestamp':
                return date('Y-d-m',$field);
            break;

            default:
                //TODO throw error
            break;

        }
    }

    public function getHtml(Array $options)
    {
        $html = '';
        $isFirstLine = true;
        $this->options = $options;

        $filterOut          = isset($options['filterOut'])? $options['filterOut'] : array();
        $aliases            = isset($options['aliases'])? $options['aliases'] : array();
        $dataFormatter      = isset($options['dataFormatter'])? $options['dataFormatter'] : array();
        $editUrl            = isset($options['editUrl'])? $options['editUrl'] : null;
        $enableDelete       = isset($options['enableDelete'])? true : false;

        $rowset = $this->tableGateway->select(function(Select $select)
        {

            $allParams =array_merge($this->params,$this->options);
            foreach($allParams as $key=>$field)
            {
                switch($key)
                {
                    case 'orderBy':
                        $select->order($field.' '.$allParams['order']);
                    break;
                }
            }
            //Todo check $options for jointures
        });

        $html.= '<table class="table table-striped">';
        while($row = $rowset->current())
        {
            if($isFirstLine)
            {
                //if it is the first line we create the headers
                $isFirstLine = false;
                $html.= '<thead>';
                $html.= '<tr>';
                foreach($row as $key=>$field)
                {
                    if(!in_array($key,$filterOut))
                    {
                        $html.= '<th>';
                        $html.= isset($aliases[$key])? $aliases[$key] : $key;
                        $html.= '<div style="text-align: left;">';
                        $html.= '<a href="'.$this->getUrl(array('order'=>'DESC','orderBy'=>$key)).'">';
                        if(isset($this->params['order']) && $this->params['order'] == 'DESC'
                            && $this->params['orderBy'] == $key)
                            $html.= '<span class="active glyphicon glyphicon-chevron-down"></span>';
                        else
                            $html.= '<span class="glyphicon glyphicon-chevron-down"></span>';
                        $html.= '</a>';
                        $html.= '<a href="'.$this->getUrl(array('order'=>'ASC','orderBy'=>$key)).'">';
                        if(isset($this->params['order']) && $this->params['order'] == 'ASC'
                            && $this->params['orderBy'] == $key)
                            $html.= '<span class="active glyphicon glyphicon-chevron-up"></span>';
                        else
                            $html.= '<span class="glyphicon glyphicon-chevron-up"></span>';
                        $html.= '</a>';
                        $html.= '</div>';
                        $html.= '</th>';
                    }
                }
                if($editUrl)    //append column for edit
                    $html.= '<th></th>';
                if($enableDelete)    //append column for delete
                    $html.= '<th></th>';

                $html.= '</tr>';
                $html.= '</thead>';
            }

            $html.= '<tr>';
            foreach($row as $key=>$field)
            {
                if(isset($dataFormatter[$key]))
                {
                    $field = $this->dataFormatter($field,$dataFormatter[$key]);
                }
                if(!in_array($key,$filterOut))
                {
                    $html.= '<td>';
                    $html.= $field;
                    $html.= '</td>';
                }
            }

            if($editUrl)
            {
                $editUrl = str_replace(':s','%s',$editUrl);
                $html.= '<td>';
                $html.= '<a href="'.sprintf($editUrl,$row->id).'" class="edit"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>';
                $html.= '</td>';
            }

            if($enableDelete)
            {
                $html.= '<td>';
                $html.= '<a href="" class="delete"><span class="glyphicon glyphicon-trash"></span></a>';
                $html.= '</td>';
            }

            $html.= '</tr>';

            $rowset->next();
        }
        $html.= '</table>';
        return $html;
    }
}