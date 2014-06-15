<?php

namespace Application\Controller;

use Admin\Filter\EditUserFilter;
use Admin\Form\EditUserForm;
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
        $userId     = $this->identity()->id;
        $userInfos  = $this->getUserTable()->getUser($userId);
        $offer      = $this->getOfferTable()->getOffer($userInfos->offer_id);

        return new ViewModel(array('userInfos'  => $userInfos,
                                   'offer'      => $offer));
    }

    public function offersAction()
    {
        $editUserFilter = new EditUserFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $form = new EditUserForm($this->getOfferTable());
        $userRow = $this->getUserTable()->getUser($this->identity()->id);
        $user = new User();
        $user->exchangeRow($userRow);
        $userData = $user->returnArray();
        $userData['password'] = '';
            $form->setInputFilter($editUserFilter->getInputFilter());
            $form->setData($userData, array('password',
                'subscription_date',
                'last_connection_date'));

        return new ViewModel(array('form' => $form));
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
