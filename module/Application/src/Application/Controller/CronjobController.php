<?php

namespace Application\Controller;

use Application\Helper\WorkerHelper;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\User;
use Zend\Crypt\Password\Bcrypt;

class CronjobController extends AbstractActionController
{
    public function __construct()
    {

    }
    
    /**
     * 
     * @return Application\Model\UserTable
     */
    private function getUserTable()
    {
        if(!isset($this->userTable))
        {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Application\Model\UserTable');
        }
        return $this->userTable;
    }

    /**
     *
     * @return Application\Model\TokenTable
     */
    private function getTokenTable()
    {
        if(!isset($this->tokenTable))
        {
            $sm = $this->getServiceLocator();
            $this->tokenTable = $sm->get('Application\Model\TokenTable');
        }
        return $this->tokenTable;
    }

    /**
     *
     * @return Application\Model\WorkerTable
     */
    private function getWorkerTable()
    {
        if(!isset($this->workerTable))
        {
            $sm = $this->getServiceLocator();
            $this->workerTable = $sm->get('Application\Model\WorkerTable');
        }
        return $this->workerTable;
    }

    /**
     *
     * @return Application\Model\OfferTable
     */
    private function getOfferTable()
    {
        if(!isset($this->offerTable))
        {
            $sm = $this->getServiceLocator();
            $this->offerTable = $sm->get('Application\Model\OfferTable');
        }
        return $this->offerTable;
    }
    
    /**
     * 
     * @param type $text
     * @return Translator
     */
    private function getTranslator()
    {
        if(!isset($this->translator))
        {
            $this->translator = $this->getServiceLocator()->get('Translator');
        }
        return $this->translator;
    }
    
    public function indexAction()
    {

    }

    public function updateWorkersAction()
    {
        $workerHelper = new WorkerHelper($this->getWorkerTable());
        $workers = $this->getWorkerTable()->fetchAll();
        foreach($workers as $worker)
        {
            $res = $workerHelper->pingWorker($worker->ws1);
	    echo $res."\n---------------------------\n";
            if($res)
            {
                $space = explode("\n",$res);
                $space = $space[1];
//echo "SPACE : ".$space;
preg_match_all("#[^0-9]{1,}([0-9]{1,})[^0-9]{1,}#USi",$space,$out);
                $space = explode(" ",$space);
//echo "\n EXPLODED : ";
//print_r($out);
                $usedSpace = ((int)$out[1][1] - (int)$out[1][2]) * 1000;
                $freeSpace = (int)$out[1][2] * 1000;
                var_dump($usedSpace);
                var_dump($freeSpace);
                $this->getWorkerTable()->update(array('status' => 'up',
                                                      'used_space_bytes' => $usedSpace,
                                                      'free_space_bytes' => $freeSpace,
                                                      'last_update' => time(),
                                                     ),array('id' => $worker->id));

            }
            else
            {
                $this->getWorkerTable()->update(array('status' => 'down',
                                                      'last_update' => time()),array('id' => $worker->id));
            }
        }
    }
}
