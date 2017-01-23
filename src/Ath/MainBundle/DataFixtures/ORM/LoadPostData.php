<?php
namespace Ath\MainBundle\DataFixtures\ORM;

use Ath\MainBundle\DataFixtures\ORM\AbstractDataFixture;
use Ath\MainBundle\Entity\Post;
use Ath\MainBundle\Entity\FilePost;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadPostData extends AbstractDataFixture
{
    /**
     * @override
     */
    public function doLoad()
    {
        $manager = $this->manager;

        $allFixtures = $this->getFixtures($manager);

        $sPathOrigine = $this->container->get('kernel')->getRootDir() . "/../data/post";
        $dataCache = $this->container->get('kernel')->getRootDir() . "/../data_cache/post";

        if(!file_exists($dataCache) ){
            mkdir("data_cache/post");
        }
        $post = $manager->getRepository('Ath\MainBundle\Entity\Post');

        foreach ($allFixtures as $fixture) {

            // On ne créer pas l'objet si il existe
            $exist = $post->findOneByContenu($fixture["setContenu"]);
            if ( $exist ) continue;

            $entity = new Post();

            // on set tous les champs
            foreach($fixture as $key => $value ) {
                switch ($key) {

                    case 'setFilePosts': {
                        foreach ($value as $oneFilePost) {
                            if($oneFilePost[0] == 1)
                            {
                                $filePost = new FilePost();
                                $filePost->setNomFichier('france.jpg');
                                $filePost->setTypeFichier('jpeg');
                                $filePost->setOriginalFichier('team_france.jpg');

                            }
                            else{
                                $filePost = new FilePost();
                                $filePost->setNomFichier('france.jpg');
                                $filePost->setTypeFichier('jpeg');
                                $filePost->setOriginalFichier('team_france.jpg');
                            }
                        
                            $filePost->setPost($entity);

                            $entity->addFilePost($filePost);
                            $photoId = $filePost->getNomFichier();
                            $photoOriginalName = $filePost->getOriginalFichier();
                           
                            copy($sPathOrigine . DIRECTORY_SEPARATOR . $photoOriginalName, $dataCache . DIRECTORY_SEPARATOR . $photoOriginalName);
                            $file = new UploadedFile($dataCache . DIRECTORY_SEPARATOR . $photoOriginalName, $photoOriginalName, null, null, null, true);
                         
                            $filePost->setFile($file);
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
        $user = $this->manager->getRepository('AthUserBundle:User')->findOneByEmail("redstar@gmail.com");

       

        $fixtures = array(
            array(
                "setContenu" => "Rejoignez-nous !",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable !",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Rejoignez-nous !!",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable !!",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Rejoignez-nous !!!",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable !!!",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Rejoignez-nous !!!!",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable !!!!",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Rejoignez-nous !!!!!",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable !!!!!",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Rejoignez-nous !!!!!!",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable !!!!!!",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Rejoignez-nous !!!!!!!",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable !!!!!!!",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Rejoignez-nous2",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable2",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Rejoignez-nous2 !!",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable2 !!",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Rejoignez-nous3 !!!",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable3 !!!",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Rejoignez-nous4 !!!!",
                "setFilePosts" => array(1),
                "setCreatedBy" => $user
            ),
            array(
                "setContenu" => "Victoire inoubliable4 !!!!",
                "setFilePosts" => array(2),
                "setCreatedBy" => $user
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
        return 7;
    }
}