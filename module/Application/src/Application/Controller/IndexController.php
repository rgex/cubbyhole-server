<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\User;
use Application\Form\RegisterForm;
use Application\Form\LoginForm;
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
        $this->layout()->setVariable('activeTab', 'login');
        $form = new LoginForm();
        
        if($this->getRequest()->isPost())
        {
            $form->setData($this->getRequest()->getPost());
            if($form->isValid())
            {
                $data = $form->getData();
                $userData = $this->getUserTable()->login($data['email'],$data['password']);
                if($userData)
                {
                    //everything O.K
                    $this->getServiceLocator()->get('AuthService')->getStorage()->write($userData);

                }
                else
                {
                    //Login failed 
                    $this->flashMessenger()->addErrorMessage(
                            $this->getTranslator()->translate('Wrong email or password.')
                            );
                }
            }
        }
        $messages = null;
        var_dump($this->flashMessenger()->getCurrentMessages());
        if($this->flashMessenger()->hasMessages())
            $messages = $this->flashMessenger()->getMessages();
        return new ViewModel(array('form'     => $form,
                                   'messages' => $messages));
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
                        array('subscription_date'       => time(),
                              'last_connection_date'    => time(),
                              'subscription_ip'         => $_SERVER['REMOTE_ADDR'],
                              'role'                    => 'Customer'));
                $bcrypt = new Bcrypt();
                $password = $data['password'];
                $data['password'] = $bcrypt->create($password); //hashing password
                $user->exchangeArray($data);
                $this->getUserTable()->insert($user->returnArray(array('id')));
                
                
                $userData = $this->getUserTable()->login($data['email'],$password);
                if($userData)
                {
                    //everything O.K
                    $this->getServiceLocator()->get('AuthService')->getStorage()->write($userData);
                }
                else
                {
                    //Subscription failed because of an unknown error
                    //TODO flash error message to tell the customer to retry later
                    echo "Subscription failed";
                    die();
                }
            }
        }
        return new ViewModel(array('form' => $form));
    }
}
