<?php

namespace Application\Test;

class StartTest extends \Extensions_Selenium2TestCaseTest
{
    public function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://cubbyhole/');
    }
}