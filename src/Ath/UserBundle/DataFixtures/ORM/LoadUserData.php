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
                $entity->{$key}($value);
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
        $dateOfBirth = new \DateTime("1993-09-05");
        $dateOfBirth->createFromFormat("Y-M-d H:i:s", "1993-01-01");

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
                "setIsCelebrite" => 0
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
                "setIsCelebrite" => 0
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
                "setIsCelebrite" => 0
            )
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
        return 0;
    }
}