<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\User;
use Zend\Crypt\Password\Bcrypt;

class WsController extends AbstractActionController
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

    public function loginAction()
    {
        if(isset($_POST['email']) && isset($_POST['password'])){
            $userRow = $this->getUserTable()->login($_POST['email'],$_POST['password']);
            $userId = isset($userRow->id)? $userRow->id : null;
            if($userId)
            {
                $token  = $this->getTokenTable()->getOrCreateToken($userId);
                $worker = $this->getWorkerTable()->getActiveWorker();
                $res = array('token' => $token,
                             'ws1' => $worker->ws1,
                             'ws2' => $worker->ws2);

                die(json_encode($res));
            }
            else
            {
                die(json_encode(array('error' => 'wrong email / password')));
            }
        }
        else {
            die(json_encode(array('error' => 'you have to provide an email and a password')));
        }
    }

    public function logoutAction()
    {
        if(isset($_POST['token'])){
            $userId = $this->getTokenTable()->getUserIdWithToken($_POST['token']);
            if($userId)
            {
                $this->getTokenTable()->delete('token = \''.$_POST['token'].'\'');
                die(json_encode(array('success' => 'success')));
            }
            else
            {
                die(json_encode(array('error' => 'invalid token')));
            }
        }
        else {
            die(json_encode(array('error' => 'no token provided')));
        }
    }

    public function getUserWithTokenAction()
    {
        if(isset($_POST['token'])){
            $userId = $this->getTokenTable()->getUserIdWithToken($_POST['token']);
            if($userId)
            {
                $user  = $this->getUserTable()->getUser($userId);
                $offer = $this->getOfferTable()->getOffer($user->offer_id);

                $res = array('id' => $user->id,
                             'downloadSpeed' => $offer->maximum_download_speed * 1000000,
                             'uploadSpeed' => $offer->maximum_upload_speed * 1000000,
                             'maximalSpace' => $offer->size_go * 1000000000,
                             'nbrOfFiles' => $user->nbr_of_files,
                             'spaceUsed' => $user->space_used_in_bytes);

                die(json_encode($res));
            }
            else
            {
                die(json_encode(array('error' => 'invalid token')));
            }
        }
        else {
            die(json_encode(array('error' => 'no token provided')));
        }
    }

    public function updateDiskSpaceAction()
    {
        if(isset($_POST['token'])){
            $userId = $this->getTokenTable()->getUserIdWithToken($_POST['token']);
            if($userId)
            {
                $res = array();
                if(isset($_POST['added']) && $_POST['added'] > 0)
                {
                    $this->getUserTable()->addDiskUsage($userId, $_POST['added']*1);
                    $res[] = 'added space : '.$_POST['added']*1;
                }
                if(isset($_POST['removed']) && $_POST['removed'] > 0)
                {
                    $this->getUserTable()->addDiskUsage($userId, $_POST['removed']*-1);
                    $res[] = 'removed space : '.$_POST['removed']*-1;
                }
                if(isset($_POST['addedFiles']) && $_POST['addedFiles'] > 0)
                {
                    $this->getUserTable()->addFiles($userId, $_POST['addedFiles']*1);
                    $res[] = 'added files : '.$_POST['addedFiles']*1;
                }
                if(isset($_POST['removedFiles']) && $_POST['removedFiles'] > 0)
                {
                    $this->getUserTable()->addFiles($userId, $_POST['removedFiles']*-1);
                    $res[] = 'removed files : '.$_POST['removedFiles']*-1;
                }
                die(json_encode($res));
            }
            else
            {
                die(json_encode(array('error' => 'invalid token')));
            }
        }
        else {
            die(json_encode(array('error' => 'no token provided')));
        }
    }
}
