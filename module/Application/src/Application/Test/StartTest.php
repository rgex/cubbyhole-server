<?php

namespace Application\Test;

class StartTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://cubbyhole/');
    }
}