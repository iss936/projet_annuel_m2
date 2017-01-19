<?php
namespace Ath\MainBundle\DataFixtures\ORM;

use Ath\MainBundle\DataFixtures\ORM\AbstractDataFixture;
use Ath\MainBundle\Entity\UserFollow;

class LoadUserFollowData extends AbstractDataFixture
{
    /**
     * @override
     */
    public function doLoad()
    {
        $manager = $this->manager;
        $userFollow = $manager->getRepository('Ath\MainBundle\Entity\UserFollow');

        $allFixtures = $this->getFixtures($manager);

        foreach ($allFixtures as $fixture) {

            // On ne créer pas l'objet si il existe
            $exist = $userFollow->findOneBy(array('userEmetteur' => $fixture["setUserEmetteur"], 'userDestinataire' => $fixture["setUserDestinataire"]));
            if ( $exist ) continue;

            $entity = new UserFollow();

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
        $esgi = $this->manager->getRepository('Ath\UserBundle\Entity\User')->findOneByEmail("redstar@gmail.com");

        $users = $this->manager->getRepository('Ath\UserBundle\Entity\User')->getAllExceptMe($esgi);
        $fixtures = array();

        foreach ($users as $oneUser) {
            $fixtures[] = array(
                "setUserDestinataire" => $esgi,
                "setUserEmetteur" => $oneUser,
                "setAccepte" => 1,
                "setDateDemande" => new \DateTime(),
                "setDateReponse" => new \DateTime(),
            );
        }

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
        return 5;
    }
}