<?php
namespace Ath\MainBundle\DataFixtures\ORM;

use Ath\MainBundle\DataFixtures\ORM\AbstractDataFixture;
use Ath\MainBundle\Entity\Comment;

class LoadCommentData extends AbstractDataFixture
{
    /**
     * @override
     */
    public function doLoad()
    {
        $manager = $this->manager;

        $allFixtures = $this->getFixtures($manager);
        $comment = $manager->getRepository('Ath\MainBundle\Entity\Comment');

        foreach ($allFixtures as $fixture) {

            // On ne créer pas l'objet si il existe
            $exist = $comment->findOneByMessage($fixture["setMessage"]);
            if ($exist) continue;

            $entity = new Comment();

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
        $user = $this->manager->getRepository('AthUserBundle:User')->findOneByEmail("soumare.iss@gmail.com");
        $amis = $this->manager->getRepository('AthUserBundle:User')->getAmiFollows($user);

        $posts = $this->manager->getRepository('AthMainBundle:Post')->getLimitfeed($user, $amis);

        $fixtures = array();
        for ($i=1; $i <= 11 ; $i++) {
            $fixtures[] = array(
            "setMessage" => "lol".$i,
            "setPost" => $posts[0],
            "setCreatedBy" => $user);
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
        return 8;
    }
}