<?php

namespace Ath\MainBundle\Tests;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Ath\MainBundle\Tests\WebTestCase;

class IsolatedWebTestCase extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = self::createClient();
        var_dump($this->client);
        die();
        $this->client->startIsolation();
    }

    public function tearDown()
    {
        if (null !== $this->client) {
            $this->client->stopIsolation();
        }

        parent::tearDown();
    }
}