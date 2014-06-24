<?php

namespace Application\Test;

class LoginTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://cubbyhole/');
    }

    public function login()
    {
        $this->setBrowserUrl('http://cubbyhole/login');
    }
}