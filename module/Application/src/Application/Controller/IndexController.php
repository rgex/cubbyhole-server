<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\User;
use Application\Form\RegisterForm;

class IndexController extends AbstractActionController
{
    public function __construct()
    {

    }
    
    private function getUserTable() {
        if(!$this->userTable)
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
        $form = new RegisterForm();
        
        $this->layout()->setVariable('activeTab', 'register');
        return new ViewModel(array('form' => $form));
    }
}
