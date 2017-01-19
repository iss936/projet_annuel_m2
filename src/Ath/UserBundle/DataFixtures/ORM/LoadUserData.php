<?php
namespace Ath\UserBundle\DataFixtures\ORM;

use Ath\MainBundle\DataFixtures\ORM\AbstractDataFixture;
use Ath\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadUserData extends AbstractDataFixture
{
    /**
     * @override
     */
    public function doLoad()
    {
        $manager = $this->manager;
        $userManager = $manager->getRepository('Ath\UserBundle\Entity\User');

        $allFixtures = $this->getFixtures($manager);
        $sPathOrigine = $this->container->get('kernel')->getRootDir() . "/../data/profil";
        $dataCache = $this->container->get('kernel')->getRootDir() . "/../data_cache/profil";
        
        if(!file_exists($dataCache) ){
            mkdir("data_cache/profil");
        }

        foreach ($allFixtures as $fixture) {

            // On ne créer pas l'objet si il existe
            $exist = $userManager->findByUsername($fixture["setUsername"]);
            if ( $exist ) continue;

            $entity = new User();

            // on set tous les champs
            foreach($fixture as $key => $value ) {
                switch ($key) {

                    case 'setUserInteretSports': {
                        foreach ($value as $oneSport) {
                            $entity->addUserInteretSport($oneSport);
                        }
                        break;
                    }
                    case 'setAssociationSports': {
                        foreach ($value as $oneSport) {
                            $entity->addAssociationSport($oneSport);
                        }
                        break;
                    }
                    default: {
                        $entity->{$key}($value);
                        break;
                    }
                }
            }
            if (isset($fixture["setPhotoId"])) {
                $photoId = $fixture["setPhotoId"];
                $photoOriginalName = $fixture["setPhotoOriginalName"];
               
                copy($sPathOrigine . DIRECTORY_SEPARATOR . $photoOriginalName, $dataCache . DIRECTORY_SEPARATOR . $photoOriginalName);
                $file = new UploadedFile($dataCache . DIRECTORY_SEPARATOR . $photoOriginalName, $photoId, null, null, null, true);
             
                $entity->setFile($file);
            }
            

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
        $dateOfBirth = new \DateTime("1993-05-05");
        $dateOfBirth->createFromFormat("Y-M-d H:i:s", "1993-05-01");

        $dateOfBirth2 = new \DateTime("1990-09-05");
        $dateOfBirth2->createFromFormat("Y-M-d H:i:s", "1990-01-01");

        $dateOfBirth3 = new \DateTime("1987-08-05");
        $dateOfBirth3->createFromFormat("Y-M-d H:i:s", "1987-08-05");

        $allSport = $this->manager->getRepository('AthMainBundle:Sport')->findAll();

        $fixtures = array(
            array(
                "setUsername" => "soumare.iss@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "soumare.iss@gmail.com",
                "addRole" => "ROLE_SUPER_ADMIN",
                "setPrenom" => "Super",
                "setNom" => "Admin",
                "setDateDeNaissance" => $dateOfBirth,
                "setRue" => "3 place des lotus",
                "setVille" => "Aulnay-Sous-Bois",
                "setCp" => "93600",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 1, // 1 = H et 2 pour F  3 pour Association
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[3], $allSport[0], $allSport[2]),
                "setPhotoId" => "issa.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "issa.jpg"
            ),
            array(
                "setUsername" => "john@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "john@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "John",
                "setNom" => "Doe",
                "setDateDeNaissance" => $dateOfBirth,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Saint-mandé",
                "setCp" => "94160",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 1,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[3], $allSport[0], $allSport[1]),
                "setPhotoId" => "john.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "john.jpg"
            ),
            array(
                "setUsername" => "redstar@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "redstar@gmail.com",
                "setRoles" => array("ROLE_USER","ROLE_ASSOC"),
                "setNom" => "redstar",
                "setDateDeCreation" => $dateOfBirth,
                "setRue" => "92, rue du Docteur Bauer",
                "setVille" => "Saint-Ouen",
                "setCp" => "93400 ",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 3,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setSiteWeb" => "http://www.redstar.fr/",
                "setUserInteretSports" => array($allSport[10], $allSport[0], $allSport[2]),
                "setAssociationSports" => array($allSport[1],$allSport[2]),
                "setPhotoId" => "redstar.png",
                "setPhotoExtension" => "png",
                "setPhotoOriginalName" => "redstar.png"
            ),
            array(
                "setUsername" => "femme1@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "femme1@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "femme1",
                "setNom" => "femme1",
                "setDateDeNaissance" => $dateOfBirth2,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Marseille",
                "setCp" => "13000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 2,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2]),
                "setPhotoId" => "femme1.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "femme1.jpg"
            ),
            array(
                "setUsername" => "teddy@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "teddy@gmail.com",
                "setRoles" => array("ROLE_USER","ROLE_CELEBRITE"),
                "setPrenom" => "Teddy",
                "setNom" => "Riner",
                "setDateDeNaissance" => $dateOfBirth3,
                "setRue" => "rue de paris",
                "setVille" => "Paris",
                "setCp" => "75000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 1, // 1 = H et 2 pour F  3 pour Association
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 1,
                "setUserInteretSports" => array($allSport[10], $allSport[0], $allSport[3]),
                "setPhotoId" => "teddy.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "teddy.jpg"
            ),
            array(
                "setUsername" => "femme2@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "femme2@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "femme2",
                "setNom" => "femme2",
                "setDateDeNaissance" => $dateOfBirth2,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Marseille",
                "setCp" => "13000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 2,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2]),
                "setPhotoId" => "femme2.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "femme2.jpg"
            ),
            array(
                "setUsername" => "femme3@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "femme3@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "femme3",
                "setNom" => "femme3",
                "setDateDeNaissance" => $dateOfBirth2,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Marseille",
                "setCp" => "13000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 2,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2]),
                "setPhotoId" => "femme3.png",
                "setPhotoExtension" => "png",
                "setPhotoOriginalName" => "femme3.png"
            ),
            array(
                "setUsername" => "femme4@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "femme4@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "femme4",
                "setNom" => "femme4",
                "setDateDeNaissance" => $dateOfBirth2,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Marseille",
                "setCp" => "13000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 2,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2]),
                // "setPhotoId" => "femme4.png",
                // "setPhotoExtension" => "png",
                // "setPhotoOriginalName" => "femme4.png"
            ),
            array(
                "setUsername" => "femme5@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "femme5@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "femme5",
                "setNom" => "femme5",
                "setDateDeNaissance" => $dateOfBirth2,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Marseille",
                "setCp" => "13000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 2,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2]),
                "setPhotoId" => "femme5.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "femme5.jpg"
            ),
            array(
                "setUsername" => "homme1@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "homme1@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "homme1",
                "setNom" => "homme1",
                "setDateDeNaissance" => $dateOfBirth2,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Marseille",
                "setCp" => "13000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 1,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2]),
                // "setPhotoId" => "homme1.jpg",
                // "setPhotoExtension" => "jpeg",
                // "setPhotoOriginalName" => "homme1.jpg"
            ),
            array(
                "setUsername" => "homme2@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "homme2@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "homme2",
                "setNom" => "homme2",
                "setDateDeNaissance" => $dateOfBirth2,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Marseille",
                "setCp" => "13000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 1,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2]),
                "setPhotoId" => "homme2.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "homme2.jpg"
            ),
            array(
                "setUsername" => "homme3@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "homme3@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "homme3",
                "setNom" => "homme3",
                "setDateDeNaissance" => $dateOfBirth2,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Marseille",
                "setCp" => "13000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 1,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2]),
                "setPhotoId" => "homme3.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "homme3.jpg"
            ),
            array(
                "setUsername" => "homme4@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "homme4@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "homme4",
                "setNom" => "homme4",
                "setDateDeNaissance" => $dateOfBirth2,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Marseille",
                "setCp" => "13000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 1,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2]),
                "setPhotoId" => "homme4.jpg",
                "setPhotoExtension" => "jpeg",
                "setPhotoOriginalName" => "homme4.jpg"
            ),
            array(
                "setUsername" => "homme5@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "homme5@gmail.com",
                "addRole" => "ROLE_USER",
                "setPrenom" => "homme5",
                "setNom" => "homme5",
                "setDateDeNaissance" => $dateOfBirth2,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Marseille",
                "setCp" => "13000",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 1,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2]),
                // "setPhotoId" => "homme5.jpg",
                // "setPhotoExtension" => "jpeg",
                // "setPhotoOriginalName" => "homme5.jpg"
            ),
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
        return 4;
    }
}