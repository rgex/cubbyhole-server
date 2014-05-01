<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\User;
use Application\Form\RegisterForm;
use Application\Filter\RegisterFilter;
use Zend\Crypt\Password\Bcrypt;

class IndexController extends AbstractActionController
{
    public function __construct()
    {

    }
    
    /**
     * 
     * @return Application\Model\UserTable
     */
    private function getUserTable() {
        if(!isset($this->userTable))
        {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Application\Model\UserTable');
        }
        return $this->userTable;
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function loginAction()
    {
        $this->layout()->setVariable('activeTab', 'login');
        return new ViewModel();
    }
    
    public function registerAction()
    {
        $this->layout()->setVariable('activeTab', 'register');
        $form = new RegisterForm();
        if($this->getRequest()->isPost())
        {
            $registerFilter = new RegisterFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
            $form->setInputFilter($registerFilter->getInputFilter());
            $form->setData($this->getRequest()->getPost());
            
            if($form->isValid())
            {
                $user = new User();
                $data = array_merge($form->getData(),
                        array('subscriptionDate'       => time(),
                              'lastConnectionDate'    => time(),
                              'subscriptionIp'         => $_SERVER['REMOTE_ADDR']));
                $bcrypt = new Bcrypt();
                $data['password'] = $bcrypt->create($data['password']); //hashing password
                $user->exchangeArray($data);
                $this->getUserTable()->insert($user->returnArray(array('id','privilege')));
                
                //TODO autologin
                
            }
        }
        return new ViewModel(array('form' => $form));
    }
}
