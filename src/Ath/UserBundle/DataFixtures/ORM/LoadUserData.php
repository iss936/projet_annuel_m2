<?php
namespace Ath\UserBundle\DataFixtures\ORM;

use Ath\MainBundle\DataFixtures\ORM\AbstractDataFixture;
use Ath\UserBundle\Entity\User;

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
            ),
            array(
                "setUsername" => "esgi@gmail.com",
                "setPlainPassword" => "esgi",
                "setEmail" => "esgi@gmail.com",
                "setRoles" => array("ROLE_USER","ROLE_ASSOC"),
                "setNom" => "ESGI",
                "setDateDeCreation" => $dateOfBirth,
                "setRue" => "12 avenue du général de Gaulle",
                "setVille" => "Saint-mandé",
                "setCp" => "94160",
                "setDescription" => "Je suis ......",
                "setStatutJuridique" => 3,
                "setEnabled" => 1,
                "setCgu" => 1,
                "setIsCelebrite" => 0,
                "setSiteWeb" => "http://www.esgi.fr/ecole-informatique.html",
                "setUserInteretSports" => array($allSport[10], $allSport[0], $allSport[2]),
                "setAssociationSports" => array($allSport[1],$allSport[2])
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
                "setUserInteretSports" => array($allSport[9], $allSport[0], $allSport[2])
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
                "setUserInteretSports" => array($allSport[10], $allSport[0], $allSport[3])
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