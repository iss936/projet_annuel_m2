<?php
namespace Ath\MainBundle\DataFixtures\ORM;

use Ath\MainBundle\DataFixtures\ORM\AbstractDataFixture;
use Ath\MainBundle\Entity\EventAdmin;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadEventAdminData extends AbstractDataFixture
{
    /**
     * @override
     */
    public function doLoad()
    {
        $manager = $this->manager;
        $eventAdmin = $manager->getRepository('Ath\MainBundle\Entity\EventAdmin');

        $allFixtures = $this->getFixtures($manager);

        $sPathOrigine = $this->container->get('kernel')->getRootDir() . "/../data/eventAdmin";
        $dataCache = $this->container->get('kernel')->getRootDir() . "/../data_cache/eventAdmin";
        if(!file_exists($dataCache) ){
            mkdir("data_cache/eventAdmin");
        }
      

        foreach ($allFixtures as $fixture) {
            // On ne créer pas l'objet si il existe
            $exist = $eventAdmin->findOneByLibelle($fixture["setLibelle"]);
            if ( $exist ) continue;

            $entity = new EventAdmin();

            // on set tous les champs
            foreach($fixture as $key => $value ) {
                switch ($key) {

                    case 'setThemeSports': {
                        foreach ($value as $oneSport) {
                            $entity->addThemeSport($oneSport);
                        }
                        break;
                    }
                    default: {
                        $entity->{$key}($value);
                        break;
                    }
                }
            }
            $photoId = $fixture["setPhotoId"];
            $photoOriginalName = $fixture["setPhotoOriginalName"];
           
            copy($sPathOrigine . DIRECTORY_SEPARATOR . $photoOriginalName, $dataCache . DIRECTORY_SEPARATOR . $photoOriginalName);
            $file = new UploadedFile($dataCache . DIRECTORY_SEPARATOR . $photoOriginalName, $photoId, null, null, null, true);
         
            $entity->setFile($file);
            
            $manager->persist($entity);
            $manager->flush();
        }
    }

    /**
     * Datas Fixtures Creation
     *
     * @return array Multidimentional array which contain every all fixtures to loading
     */
    private function getFixtures()
    {
        $dateDebut1 = new \DateTime("2016-07-01");
        $dateFin1 = new \DateTime("2016-07-01");
        $dateFin1 =  $dateFin1->add(new \DateInterval('P20D'));

        $dateDebut2 = new \DateTime("2016-07-02");
        $dateFin2 = new \DateTime("2016-07-02");
        $dateFin2 =  $dateFin2->add(new \DateInterval('P20D'));

        $dateDebut3 = new \DateTime("2016-07-03");
        $dateFin3 = new \DateTime("2016-07-03");
        $dateFin3 =  $dateFin3->add(new \DateInterval('P20D'));

        $dateDebut4 = new \DateTime("2016-07-04");
        $dateFin4 = new \DateTime("2016-07-04");
        $dateFin4 =  $dateFin3->add(new \DateInterval('P20D'));

        $admin = $this->manager->getRepository('AthUserBundle:User')->findOneByEmail("soumare.iss@gmail.com");

        $allSport = $this->manager->getRepository('AthMainBundle:Sport')->findAll();

        $fixtures = array(
            array(
                "setLibelle" => "France vs Irelande ",
                "setDescription" => "Venez assister au match des bleus face aux irelandais loremipsumloremipsumloremipsum",
                "setDateDebut" => new \DateTime(),
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "france.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "team_france.jpg"
            ),
            array(
                "setLibelle" => "Cleveland vs lakers",
                "setDescription" => "Venez assister au match des Cleveland face aux lakers loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => new \DateTime(),
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[1]),
                "setPhotoId" => "lebron.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "lebron_james.jpg"
            ),
            array(
                "setLibelle" => "Dirk nowitski s'entraîne avec le club de nanterre",
                "setDescription" => "Venez assister aux entraînement de dirk nowitski loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut1,
                "setDateFin" => $dateFin1,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[1]),
                "setPhotoId" => "dirk.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "dirk_nowitzki.jpg"
            ),
            array(
                "setLibelle" => "Arturo Vidal",
                "setDescription" => "Arturo vidal au parc des expositions de villepinte loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut2,
                "setDateFin" => $dateFin2,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "arturo.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "aruro_v.jpg"
            ),
            array(
                "setLibelle" => "Djokovic nouveau Champions Rolland Garros?",
                "setDescription" => "Venez assister à la finale de rolland Garros opposant Djokovic à Murray",
                "setDateDebut" => new \DateTime(),
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[3]),
                "setPhotoId" => "djokovic.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "djokovic.jpg"
            ),
            array(
                "setLibelle" => "Djokovic nouveau Champions Rolland Garros1?",
                "setDescription" => "Venez assister à la finale de rolland Garros opposant Djokovic à Murray",
                "setDateDebut" => new \DateTime(),
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[3]),
                "setPhotoId" => "djokovic.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "djokovic.jpg"
            ),
            array(
                "setLibelle" => "Djokovic nouveau Champions Rolland Garros2?",
                "setDescription" => "Venez assister à la finale de rolland Garros opposant Djokovic à Murray",
                "setDateDebut" => new \DateTime(),
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[3]),
                "setPhotoId" => "djokovic.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "djokovic.jpg"
            ),
            array(
                "setLibelle" => "Djokovic nouveau Champions Rolland Garros3?",
                "setDescription" => "Venez assister à la finale de rolland Garros opposant Djokovic à Murray",
                "setDateDebut" => new \DateTime(),
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[3]),
                "setPhotoId" => "djokovic.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "djokovic.jpg"
            ),
            array(
                "setLibelle" => "Djokovic nouveau Champions Rolland Garros4?",
                "setDescription" => "Venez assister à la finale de rolland Garros opposant Djokovic à Murray",
                "setDateDebut" => new \DateTime(),
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[3]),
                "setPhotoId" => "djokovic.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "djokovic.jpg"
            ),
             array(
                "setLibelle" => "Djokovic nouveau Champions Rolland Garros5?",
                "setDescription" => "Venez assister à la finale de rolland Garros opposant Djokovic à Murray",
                "setDateDebut" => new \DateTime(),
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[3]),
                "setPhotoId" => "djokovic.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "djokovic.jpg"
            ),
              array(
                "setLibelle" => "Djokovic nouveau Champions Rolland Garros6?",
                "setDescription" => "Venez assister à la finale de rolland Garros opposant Djokovic à Murray",
                "setDateDebut" => new \DateTime(),
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[3]),
                "setPhotoId" => "djokovic.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "djokovic.jpg"
            ),
            array(
                "setLibelle" => "Place quart de finale pour les bleus",
                "setDescription" => "loremipsumloremipsumloremipsum loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => new \DateTime(),
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "france1.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "team_france.jpg"
            ),
            array(
                "setLibelle" => "Porte ouvertes stade de France",
                "setDescription" => "loremipsumloremipsumloremipsum loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut3,
                "setDateFin" => $dateFin3,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "stade-france.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "stade-france.jpg"
            ),
            array(
                "setLibelle" => "Porte ouvertes Parc des princes",
                "setDescription" => "loremipsumloremipsumloremipsum loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut4,
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "parc-prince.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "parc-prince.jpg"
            ),
            array(
                "setLibelle" => "Porte ouvertes Parc des princes2",
                "setDescription" => "loremipsumloremipsumloremipsum loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut4,
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "parc-prince1.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "parc-prince.jpg"
            ),
            array(
                "setLibelle" => "Porte ouvertes Parc des princes3",
                "setDescription" => "loremipsumloremipsumloremipsum loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut4,
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "parc-prince2.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "parc-prince.jpg"
            ),
            array(
                "setLibelle" => "Porte ouvertes Parc des princes4",
                "setDescription" => "loremipsumloremipsumloremipsum loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut4,
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "parc-prince3.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "parc-prince.jpg"
            ),
            array(
                "setLibelle" => "Porte ouvertes Parc des princes5",
                "setDescription" => "loremipsumloremipsumloremipsum loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut4,
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "parc-prince4.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "parc-prince.jpg"
            ),
            array(
                "setLibelle" => "Porte ouvertes Parc des princes6",
                "setDescription" => "loremipsumloremipsumloremipsum loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut4,
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "parc-prince5.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "parc-prince.jpg"
            ),
            array(
                "setLibelle" => "Porte ouvertes Parc des princes7",
                "setDescription" => "loremipsumloremipsumloremipsum loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut4,
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "parc-prince6.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "parc-prince.jpg"
            ),
            array(
                "setLibelle" => "Porte ouvertes Parc des princes8",
                "setDescription" => "loremipsumloremipsumloremipsum loremipsum loremipsumloremipsumloremipsum",
                "setDateDebut" => $dateDebut4,
                "setDateFin" => $dateFin4,
                "setCreatedBy" => $admin,
                "setSiteWeb" => "http://fr.uefa.com/uefaeuro/ticketing/",
                "setThemeSports" => array($allSport[0]),
                "setPhotoId" => "parc-prince7.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "parc-prince.jpg"
            ),
            // array(
            //     "setName" => "soumare.iss@gmail.com",
            // ),
            // array(
            //     "setName" => "soumare.iss@gmail.com",
            // ),
            // array(
            //     "setName" => "soumare.iss@gmail.com",
            // ),
        );

        return $fixtures;
    }

    /**
     * @override
     */
    protected function getEnvironments()
    {
        return array('dev');
    }

    /**
     * @override
     * Ordre d'éxécution lors du chargement des fixtures
     */
    public function getOrder()
    {
        return 6;
    }
}