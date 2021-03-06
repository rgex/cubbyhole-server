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

        $this->pause(5000);
        $this->type('email', 'qa@cubbyhole.com');
        $this->type('password', '$admin971');

        $this->pause(5000);
        $this->click('submit');

        $this->pause(5000);
        $this->click('css=.icon-network');

        $this->pause(5000);
        $this->assertElementContainsText('//*[@class=\'name\']','qa-file');
        $this->click('link=qa-folder');

        $this->pause(5000);
        $this->assertElementContainsText('//*[@class=\'name\']','qa-file');

        $this->pause(3000);

    }
}