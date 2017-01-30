<?php
namespace Ath\MainBundle\DataFixtures\ORM;

use Ath\MainBundle\DataFixtures\ORM\AbstractDataFixture;
use Ath\MainBundle\Entity\CategorieProduit;

class LoadCategorieProduitData extends AbstractDataFixture
{
    /**
     * @override
     */
    public function doLoad()
    {
        $manager = $this->manager;
        $categorieProduit = $manager->getRepository('Ath\MainBundle\Entity\CategorieProduit');

        $allFixtures = $this->getFixtures($manager);

        foreach ($allFixtures as $fixture) {

            // On ne créer pas l'objet si il existe
            $exist = $categorieProduit->findOneByLibelle($fixture["setLibelle"]);
            if ( $exist ) continue;

            $entity = new CategorieProduit();

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
                "setLibelle" => "Gant de boxe",
            ),
            array(
                "setLibelle" => "Raquette de tennis",
            ),
            array(
                "setLibelle" => "kimono",
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
        return 1;
    }
}