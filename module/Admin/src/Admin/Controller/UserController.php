<?php

namespace Admin\Controller;

use Application\Model\User;
use Admin\Filter\EditUserFilter;
use Admin\Form\EditUserForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Helper\GridHelper;

class UserController extends AbstractActionController
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
        //new table helper
        $tableHelper = new GridHelper($this->getServiceLocator()->get('UserTableGateway'));
        $table = $tableHelper->getHtml(
            array('aliases'         =>  array('first_name'              =>  'First Name',
                                              'last_name'               =>  'Last Name',
                                              'subscription_date'       =>  'Subscription Date',
                                              'role'                    =>  'Role',
                                              'last_connection_date'    =>  'Last Connection Date',
                                              'email'                   =>  'E-mail',
                                             ),

                  'dataFormatter'   =>  array('subscription_date'       =>'dateFromTimestamp',
                                              'last_connection_date'    =>'dateFromTimestamp',
                                             ),


                  'filterOut'       =>  array('id','password','subscription_ip'),

                  'baseUrl'         =>  $this->url()->fromRoute('adminUser'),

                  'editUrl'         => $this->url()->fromRoute('editUser',array('id' => ':s')),

                  'enableDelete'    => true,
                 ));
        return new ViewModel(array('table' => $table));
    }

    public function editAction()
    {

        $editUserFilter = new EditUserFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $form = new EditUserForm();
        if($this->getRequest()->isPost()) {
            $form->setInputFilter($editUserFilter->getInputFilter());
            $form->setData($this->getRequest()->getPost());

            if($form->isValid())
            {
                $user = new User();
                $user->exchangeRow($this->getRequest()->getPost());
                $this->getUserTable()->update($user->returnArray(), 'id = \''.$this->params()->fromRoute('id').'\'');
                $this->flashmessenger()->addInfoMessage($this->getTranslator()->translate('The user infos have been edited.'));
                $this->redirect()->toRoute('adminUser');
            }
        }
        else
        {
            $form->setInputFilter($editUserFilter->getInputFilter());
            $form->setData($userData = $this->getUserTable()->getUserArray($this->params()->fromRoute('id'), array('password')));
        }
        return new ViewModel(array('form' => $form));
    }
}
