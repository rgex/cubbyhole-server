<?php

namespace Application\Test;


class Driver extends \PHPUnit_Extensions_SeleniumTestCase_Driver
{
    public function __construct()
    {
        $this->setHost('127.0.0.1');
        $this->setPort(4444);
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://cubbyhole/');
        $this->setWaitForPageToLoad(true);
        $this->start();
    }

}