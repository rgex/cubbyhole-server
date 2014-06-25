<?php

namespace Application\Test;


class LoginTest extends \PHPUnit_Extensions_SeleniumTestCase
{

    public function __construct()
    {
        $this->setUp();
        $this->prepareTestSession();
    }

    public function setUp()
    {
        parent::setUp();

        $this->getDriver(array('host' => 'localhost',
            'name' => 'firefox',
            'browser' => '*firefox',
            'port' => 4444,
            'timeout' => 10,
            'httpTimeout' => 10
        ));
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cubbyhole-server/");

    }

    public function login()
    {
        $this->open('/login');
        $this->waitForPageToLoad(10000);
        sleep(1);
        $this->type("edit-name", "myuser");

        echo "login";
    }
}