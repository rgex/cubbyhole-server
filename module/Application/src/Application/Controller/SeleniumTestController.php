<?php

namespace Application\Controller;

use Application\Test\LoginTest;

class SeleniumTestController extends AbstractActionController
{
    public function __construct()
    {

    }

    public function testLoginAction()
    {
        $loginTest = new LoginTest();
        $loginTest->login();
    }

}
