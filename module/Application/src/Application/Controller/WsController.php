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

}
