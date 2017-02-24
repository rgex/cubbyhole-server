<?php

namespace Application\Controller;

use Application\Test\LoginTest;
use Zend\Mvc\Controller\AbstractActionController;

class SeleniumTestController extends AbstractActionController
{

    public function loginTestAction()
    {
        $loginTest = new LoginTest();
        $loginTest->login();
    }

}
