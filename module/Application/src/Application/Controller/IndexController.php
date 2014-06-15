<?php

namespace Application\Controller;

use Application\Helper\WorkerHelper;
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
        $offers = $this->getOfferTable()->getBestOffers();
        return new ViewModel(array('offers' => $offers));
    }

    public function offerAction()
    {
        $offer = $this->getOfferTable()->getOffer($this->params()->fromRoute('id'));
        return new ViewModel(array('offer' => $offer));
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

                    //if user is a admin we redirect him to admin home page
                    if($userData->role == 'Admin')
                        $this->redirect()->toRoute('adminIndex');

                    //TODO redirect non admin user to his home
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

        return new ViewModel(array('form'     => $form));
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
                if(!$this->getWorkerTable()->getActiveWorker()) {
                    $this->flashMessenger()->addErrorMessage(
                        $this->getTranslator()->translate('Error : no active worker available, please retry later.')
                    );
                }
                else{
                    $user = new User();
                    $data = array_merge($form->getData(),
                            array('subscription_date'       => time(),
                                  'last_connection_date'    => time(),
                                  'subscription_ip'         => $_SERVER['REMOTE_ADDR'],
                                  'role'                    => 'Customer'));
                    $bcrypt = new Bcrypt();
                    $password = $data['password'];
                    $data['password'] = $bcrypt->create($password); //hashing password
                    $data['role'] = 'Customer';
                    $data['offer_id'] = 1;      //free offer
                    $data['expire'] = 0;
                    $user->exchangeArray($data);
                    $this->getUserTable()->insert($user->returnArray(array('id')));

                    $userData = $this->getUserTable()->login($data['email'],$password);
                    if($userData)
                    {
                        //everything O.K
                        $workerHelper =  new WorkerHelper($this->getWorkerTable());
                        $workerAnswer = $workerHelper->createUser($userData->id);

                        $this->getServiceLocator()->get('AuthService')->getStorage()->write($userData);
                        $this->redirect()->toRoute('customerIndex');
                    }
                    else
                    {
                        //Subscription failed because of an unknown error
                        $this->flashMessenger()->addErrorMessage(
                            $this->getTranslator()->translate('Something went wrong please retry later.')
                        );
                    }
                }
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function logoutAction()
    {
        $this->getServiceLocator()->get('AuthService')->clearIdentity();
        $this->flashmessenger()->addInfoMessage($this->getTranslator()->translate('You\'ve been logged out'));

        return new ViewModel();
    }
}
