<?php
namespace Ath\MainBundle\DataFixtures\ORM;

use Ath\MainBundle\DataFixtures\ORM\AbstractDataFixture;
use Ath\MainBundle\Entity\Sport;

class LoadSportData extends AbstractDataFixture
{
    /**
     * @override
     */
    public function doLoad()
    {
        $manager = $this->manager;
        $sport = $manager->getRepository('Ath\MainBundle\Entity\Sport');

        $allFixtures = $this->getFixtures($manager);

        foreach ($allFixtures as $fixture) {

            // On ne créer pas l'objet si il existe
            $exist = $sport->find($fixture["setName"]);
            if ( $exist ) continue;

            $entity = new Sport();

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
        $fixtures = array(
            array(
                "setName" => "Football",
            ),
            array(
                "setName" => "Basket-ball",
            ),
            array(
                "setName" => "Tennis",
            ),
            array(
                "setName" => "Rugby",
            ),
            array(
                "setName" => "Musculation",
            ),
            array(
                "setName" => "Gymnastique",
            ),
            array(
                "setName" => "Natation",
            ),
            array(
                "setName" => "Footing",
            ),
            array(
                "setName" => "Boxe",
            ),
            array(
                "setName" => "Formule 1",
            ),
            array(
                "setName" => "Judo",
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
        return 1;
    }
}