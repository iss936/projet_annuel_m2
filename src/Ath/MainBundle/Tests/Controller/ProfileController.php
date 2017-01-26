<?php

namespace Ath\UserBundle\Tests\Controller;

use Ath\MainBundle\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfileControllerTest extends WebTestCase
{
    static private $sPathOrigine;
    static private $sPathCache;

    protected $em;

    public function __construct()
    {
        $em = static::getManagerStatic();
        $this->em = $em;
    }

    public function testShowProfile()
    {
        $client = $this->getClient(null);
        $client = $this->login($client, 'soumare.iss@gmail.com', 'esgi');
        $user = $this->getUser();
        $crawler = $client->request('GET', $this->getRouter()->generate('ath_user_show_profile',array('slug' => $user->getSlug())));
        
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('h1:contains("Super Admin")')->count() == 1);
    }

   /* public function testEdit()
    {
        $this->em->getConnection()->beginTransaction();
        $this->em->getConnection()->rollback();

        $client = $this->getClient('tgilbert');
        $crawler = $client->request('GET', $this->getRouter()->generate('user_myprofile_edit'));

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertTrue($crawler->filter('form#form_profile button[type="submit"]')->count() > 0);
        $form    = $crawler->filter('form#form_profile button[type="submit"]')->form();

        $em      = $this->getManager();
        $lieu    = $em->getRepository('AtixMainBundle:Lieu')->findOneByCode('stmande');

        $form['profile[firstname]'] = "Tom";
        $form['profile[lastname]'] = "Festen";
        $form['profile[tel]']      = "0102030201";
        $form['profile[lieu]']     = $lieu->getId();
        $form['profile[file]']     = $this->preUploadDoc();

        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('h1:contains("Tom Festen")')->count() > 0);

        self::cancelProfile($em);
    }


    private function preUploadDoc()
    {
        $sFile = 'tux-1.png';
        self::$sPathOrigine = $this->getPathFile("/../web/images/avatar");
        self::$sPathCache = $this->getPathFile("/cache/test/avatar");

        if (!is_dir(self::$sPathCache)) {
            mkdir(self::$sPathCache);
        }

        copy(self::$sPathOrigine.'/'.$sFile, self::$sPathCache.'/'.$sFile);

        $photo = new UploadedFile(
            self::$sPathCache.'/'.$sFile,
            $sFile,
            'image/png',
            123
        );
        return  $photo;
    }*/

}