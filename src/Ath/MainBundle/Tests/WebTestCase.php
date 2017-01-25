<?php

namespace Ath\MainBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\HttpKernel\Util\Filesystem;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

abstract class WebTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \AppKernel
     */
    static private $kernel;

    private $username = array();
    private $password = array();

    public function __construct()
    {
    	// admin
        $this->username['soumare.iss@gmail.com'] = "soumare.iss@gmail.com";
        $this->password['soumare.iss@gmail.com'] = "esgi";
        // assoc
        $this->username['redstar@gmail.com'] = "redstar@gmail.com";
        $this->password['redstar@gmail.com'] = "esgi";
        // Celebrité
        $this->username['teddy@gmail.com'] = "teddy@gmail.com";
        $this->password['teddy@gmail.com'] = "esgi";
    }

    static protected function getManagerStatic()
    {
        self::createKernel();
        return self::$kernel->getContainer()->get('doctrine')->getManager();

    }

    /**
     * @param bool $loggedIn
     * @param bool $followRedirects
     *
     * @return \Symfony\Component\BrowserKit\Client
     */
    protected function getClient($login, $followRedirects = true)
    {
        self::createKernel();
        $client = self::$kernel->getContainer()->get('test.client');

        if ($login) {
            $this->login($client, $this->username[$login], $this->password[$login]);
        }

        if ($followRedirects) {
            $client->followRedirects();
        }

        return $client;
    }

    /**
     * @param string $route
     * @param array $parameters
     *
     * @return string
     */
    protected function generateUrl($route, array $parameters = array())
    {
        self::createKernel();

        return self::$kernel->getContainer()->get('router')->generate($route, $parameters);
    }

    /**
     * @return null|User
     */
    protected function getUser()
    {
        $token = self::$kernel->getContainer()->get('security.context')->getToken();

        return $token ? $token->getUser() : null;
    }

    /**
     * @param \Symfony\Bundle\FrameworkBundle\Client $client
     * @param string $seed
     */
    protected function login(Client $client, $username, $password)
    {
        $crawler = $client->request('GET', self::$kernel->getContainer()->get('router')->generate('user_security_login'));
        $this->assertTrue($crawler->filter('section button[type=submit]')->count() > 0);
        $form    = $crawler->filter('section button[type=submit]')->form();
        
        //on récupère les identifiants et soumet le form
        $form['_username'] = $username;
        $form['_password'] = $password;
        $client->submit($form);

        return $client;
    }

    /**
     * @param \Symfony\Component\BrowserKit\Client $client
     */
    protected function logout(Client $client)
    {
        $client->request('GET', self::$kernel->getContainer()->get('router')->generate('user_security_logout'));
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     */
    protected function dumpHtml(Crawler $crawler)
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $crawler->each(function(\DOMElement $node) use ($document) {
            $document->appendChild($document->importNode($node, true));
        });

        echo html_entity_decode($document->saveXML());
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     */
    protected function dumpException(Crawler $crawler)
    {
        $this->dumpHtml($crawler->filter('h1'));
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     */
    protected function dumpFormErrors(Crawler $crawler)
    {
        $this->dumpHtml($crawler->filter('.post-error-list'));
    }


    /**
     * Shuts the kernel down if it was used in the test.
     */
    protected function tearDown()
    {
        if (null !== self::$kernel) {
            self::$kernel->shutdown();
            self::$kernel = null;
        }
    }

    /**
     * @return \AppKernel
     */
    static private function createKernel()
    {
        require_once __DIR__.'/../../../../app/AppKernel.php';

        if (null === self::$kernel) {
            self::$kernel = new \AppKernel('test', true);
            self::$kernel->boot();
        }
    }

    protected function getRouter()
    {
        return self::$kernel->getContainer()->get('router');
    }

    protected function getManager()
    {
        return self::$kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function getPathFile($path)
    {
        return self::$kernel->getRootDir().$path;
    }

    protected function getPathWebFile($path)
    {
        return self::$kernel->getWebDir().$path;
    }

/*    protected function isRedirectLogin($client)
    {
        if ($client->getResponse()->isRedirect()) {
            if ($client->getResponse()->getTargetUrl() == "http://localhost/login")  {
                return true;
            }
        }
        return false;
    }*/

}