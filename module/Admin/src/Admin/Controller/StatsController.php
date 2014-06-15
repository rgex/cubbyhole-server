<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class StatsController extends AbstractActionController
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
        $offersCount            = $this->getOfferTable()->count();
        $usersCount             = $this->getUserTable()->count();
        $newUsersToday          = $this->getUserTable()->count('subscription_date > '.(time()-(24*3600)));
        $newUsersThisWeek       = $this->getUserTable()->count('subscription_date > '.(time()-(7*24*3600)));
        $newUsersThisMonth      = $this->getUserTable()->count('subscription_date > '.(time()-(30*24*3600)));

        $activeWorkersCount     = $this->getWorkerTable()->count('status = \'up\'');
        $inActiveWorkersCount   = $this->getWorkerTable()->count('status = \'down\'');

        $activeWorker           = $this->getWorkerTable()->getActiveWorker();

        $freeSpace              = $activeWorker->free_space_bytes;
        $usedSpace              = $activeWorker->used_space_bytes;

        return new ViewModel(array('offersCount'            => $offersCount,
                                   'usersCount'             => $usersCount,
                                   'newUsersToday'          => $newUsersToday,
                                   'newUsersThisWeek'       => $newUsersThisWeek,
                                   'newUsersThisMonth'      => $newUsersThisMonth,
                                   'activeWorkersCount'     => $activeWorkersCount,
                                   'inActiveWorkersCount'   => $inActiveWorkersCount,
                                   'activeWorker'           => $activeWorker,
                                   'freeSpace'              => $freeSpace,
                                   'usedSpace'              => $usedSpace
        ));
    }
}
