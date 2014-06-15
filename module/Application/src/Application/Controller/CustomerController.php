<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\User;
use Application\Form\RegisterForm;
use Application\Form\LoginForm;
use Application\Filter\RegisterFilter;
use Zend\Crypt\Password\Bcrypt;

class CustomerController extends AbstractActionController
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
        return new ViewModel();
    }

    public function offersAction()
    {
        return new ViewModel();
    }

    public function filesAction()
    {
        $worker = $this->getWorkerTable()->getActiveWorker();
        $userId = $this->params()->fromRoute('id');
        $userInfos = $this->getUserTable()->getUser($userId);
        if(isset($this->identity()->id) && $this->identity()->id == $this->params()->fromRoute('id'))
            $token  = $this->getTokenTable()->getOrCreateToken($this->identity()->id);
        else
            $token = null;
        if(!$userInfos)
            die('user not found');
        return new ViewModel(array('worker'     => $worker,
                                   'token'      => $token,
                                   'userInfos'  => $userInfos));
    }

}
