<?php

namespace Ath\MainBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Client as BaseClient;
use Symfony\Component\HttpFoundation\Request;

/**
 * Test client.
 */
class Client extends BaseClient
{
    protected $connection;
    protected $requested;

    protected function doRequest($request)
    {
        if ($this->requested) {
            $this->kernel->shutdown();
            $this->kernel->boot();
        }
        $this->connection = $this->getContainer()->get('doctrine.dbal.default_connection');

        // $this->injectConnection();
        $this->testBegin();
        $response = $this->kernel->handle($request);
        $this->testRollback();

        $this->requested = true;

        return $response;
    }

    private function testBegin()
    {
        $this->connection->beginTransaction();

    }

    private function testRollback()
    {
        $this->connection->rollback();
        
    }
    protected function injectConnection()
    {
        if (null === $this->connection) {
            $this->connection = $this->getContainer()->get('doctrine.dbal.default_connection');
        } else {
            if (! $this->requested) {
                $this->connection->rollback();
            }
            $this->getContainer()->set('doctrine.dbal.default_connection', $this->connection);
        }

        if (! $this->requested) {
            $this->connection->beginTransaction();
        }
    }

    public function connect($username, $password = 'esgi')
    {
        $this->followRedirects(true);
 
        $crawler = $this->request('GET', '/logout');
        $crawler = $this->request(
            'POST',
            '/login_check',
            array(
                '_username' => $username,
                '_password' => $password
            )
        );
 
        $this->followRedirects(false);
 
        return $this->crawler;
    }
}