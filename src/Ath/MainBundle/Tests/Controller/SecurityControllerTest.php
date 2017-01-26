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

        $form['_username'] = "test";
        $form['_password'] = "mdp-faux";

        $crawler = $client->submit($form);
        $this->assertTrue($crawler->filter('html:contains("L\'authentification a échoué")')->count() > 0);
        // $this->assertTrue($crawler->filter('html:contains("Se connecter")')->count() > 0);

       /* $form['_username'] = $this->username['soumare.iss@gmail.com'];
        $form['_password'] = $this->password['esgi'];

        $crawler = $client->submit($form);
        $this->assertFalse($crawler->filter('html:contains("Nom d\'utilisateur ou mot de passe incorrect")')->count() > 0);
        $this->assertFalse($crawler->filter('html:contains("Se connecter")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Mes tâches")')->count() > 0);*/

    }

 /*   public function testLogout()
    {
        $client = $this->getClient('tgilbert');
        $crawler = $client->request('GET', $this->getRouter()->generate('user_security_logout'));
        $this->assertTrue($crawler->filter('html:contains("Se connecter")')->count() > 0);
    }*/
}