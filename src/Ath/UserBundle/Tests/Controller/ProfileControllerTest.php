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
        // browserkit
        $client = $this->getClient(null);
        $client = $this->login($client, 'soumare.iss@gmail.com', 'esgi');
        $user = $this->getUser();
        $crawler = $client->request('GET', $this->getRouter()->generate('ath_user_show_profile',array('slug' => $user->getSlug())));
    
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('h1:contains("Super Admin")')->count() == 1);
    }

    public function testEdit()
    {
        $client = $this->getClient(null);
        $client = $this->login($client, 'soumare.iss@gmail.com', 'esgi');
        $crawler = $client->request('GET', $this->getRouter()->generate('fos_user_profile_edit'));

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertTrue($crawler->filter('form#form_profile input[type="submit"]')->count() == 1);
        $form    = $crawler->filter('form#form_profile input[type="submit"]')->form();

        $form['ath_user_edit_profile[nom]'] = "Admin2";
        $form['ath_user_edit_profile[prenom]'] = "Prenom2";
        $form['ath_user_edit_profile[rue]']      = "3 place des lotus2";
        $form['ath_user_edit_profile[ville]']     = "Aulnay-Sous-Bois2";
        $form['ath_user_edit_profile[cp]']     = "93602";
        $form['ath_user_edit_profile[description]']     = "Je suis passionné";

        $form['ath_user_edit_profile[file]']     = $this->preUploadDoc();

        $crawler = $client->submit($form);

        $user = $this->getUser();
        $this->assertTrue($user->getPhotoOriginalName() == 'issa2.jpg');
    }


    private function preUploadDoc()
    {
        $sFile = 'issa2.jpg';
        self::$sPathOrigine = $this->getPathFile("/../data/profil");
        self::$sPathCache = $this->getPathFile("/../data_cache/profil");

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
    }

}