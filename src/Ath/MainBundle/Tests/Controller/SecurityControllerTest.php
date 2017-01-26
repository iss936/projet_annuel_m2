<?php

namespace Ath\UserBundle\Tests\Controller;

use Ath\MainBundle\Tests\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    //fos_user_security
    //user_security_login
    //user_security_logout
    //user_security_check
    //user_security_check_type

    public function testLogin()
    {
        $client = $this->getClient(null);
        $crawler = $client->request('GET', $this->getRouter()->generate('user_security_login'));
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('form input[type="submit"]')->count() > 0);
        $form = $crawler->filter('form input[type="submit"]')->form();

        //fausse auth
        $form['_username'] = "test";
        $form['_password'] = "mdp-faux";

        $crawler = $client->submit($form);
        $this->assertTrue($crawler->filter('html:contains("L\'authentification a échoué")')->count() > 0);
        $this->assertTrue($crawler->filter('form input[name="_username"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="_password"]')->count() == 1);

        // vrai auth
        $form['_username'] = $this->username['soumare.iss@gmail.com'];
        $form['_password'] = $this->password['soumare.iss@gmail.com'];

        $crawler = $client->submit($form);
        $this->assertFalse($crawler->filter('html:contains("L\'authentification a échoué")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Nouvelle actualité")')->count() > 0);
    }

    public function testLogout()
    {
        //on récupère le browserkit et on connecte le superAdmin
        $client = $this->getClient('soumare.iss@gmail.com');
        $crawler = $client->request('GET', $this->getRouter()->generate('user_security_logout'));
        // Auth: login passwprd
        $this->assertTrue($crawler->filter('form input[name="_username"]')->count() == 1);
        $this->assertTrue($crawler->filter('form input[name="_password"]')->count() == 1);
    }
}