<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Helper\TableHelper;

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
        $tableHelper = new TableHelper($this->getServiceLocator()->get('UserTableGateway'));
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

    }
}
