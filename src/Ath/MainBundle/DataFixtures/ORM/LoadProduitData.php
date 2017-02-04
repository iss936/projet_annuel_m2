<?php
namespace Ath\MainBundle\DataFixtures\ORM;

use Ath\MainBundle\DataFixtures\ORM\AbstractDataFixture;
use Ath\MainBundle\Entity\Produit;
use Ath\MainBundle\Entity\FileProduit;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadProduitData extends AbstractDataFixture
{
    /**
     * @override
     */
    public function doLoad()
    {
        $manager = $this->manager;
        $produitManager = $manager->getRepository('Ath\MainBundle\Entity\Produit');

        $allFixtures = $this->getFixtures($manager);
        $sPathOrigine = $this->container->get('kernel')->getRootDir() . "/../data/produit";
        $dataCache = $this->container->get('kernel')->getRootDir() . "/../data_cache/produit";
        
        if(!file_exists($dataCache) ){
            mkdir("data_cache/produit");
        }

        foreach ($allFixtures as $fixture) {

            // On ne créer pas l'objet si il existe
            $exist = $produitManager->findOneByLibelle($fixture["setLibelle"]);
            if ( $exist ) continue;

            $entity = new Produit();

            // on set tous les champs
            foreach($fixture as $key => $value ) {
                switch ($key) {

                    case 'setFileProduits': {
                        // foreach ($value as $oneFileProduit) {
                            // creation d'un FileProduit en fonction de la value
                            // var_dump($value);
                            $fileProduit = $this->createFileProduit($value);
                        
                            $fileProduit->setProduit($entity);

                            $entity->addFileProduit($fileProduit);
                            $photoId = $fileProduit->getNomFichier();
                            $photoOriginalName = $fileProduit->getOriginalFichier();
                           
                            copy($sPathOrigine . DIRECTORY_SEPARATOR . $photoOriginalName, $dataCache . DIRECTORY_SEPARATOR . $photoOriginalName);
                            $file = new UploadedFile($dataCache . DIRECTORY_SEPARATOR . $photoOriginalName, $photoOriginalName, null, null, null, true);
                         
                            $fileProduit->setFile($file);
                        // }
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
        $allSport = $this->manager->getRepository('AthMainBundle:Sport')->findAll();

        // récuparation des catégories de produits
        $gantDeBoxe = $this->manager->getRepository('AthMainBundle:CategorieProduit')->findOneByLibelle("Gant de boxe");
        $kimono = $this->manager->getRepository('AthMainBundle:CategorieProduit')->findOneByLibelle("kimono");
        $raquetteTennis = $this->manager->getRepository('AthMainBundle:CategorieProduit')->findOneByLibelle("Raquette de tennis");

        // récupération des createdBy
        $teddy = $this->manager->getRepository('AthUserBundle:User')->findOneByEmail("teddy@gmail.com");
        $admin = $this->manager->getRepository('AthUserBundle:User')->findOneByEmail("soumare.iss@gmail.com");

        $fixtures = array(
            array(
                "setLibelle" => "kimono norris",
                "setDescription" => "loremipsum",
                "setCreatedBy" => $teddy,
                "setCategorieProduit" => $kimono,
                "setFileProduits" => 2,
                "setPrix" => 44.95,
                "setUrl" => "https://www.amazon.fr/adidas-Kimono-judo-Blanc-brillant/dp/B009JZCMBW/ref=sr_1_1?ie=UTF8&qid=1485706676&sr=8-1&keywords=kimono+homme+judo",
            ),
            array(
                "setLibelle" => "Raquette de tennis babolat",
                "setDescription" => "loremipsum",
                "setCreatedBy" => $admin,
                "setCategorieProduit" => $raquetteTennis,
                "setFileProduits" => 3,
                "setPrix" => 74.75,
                "setUrl" => "https://www.amazon.fr/BABOLAT-Pure-Raquette-tennis-Enfant/dp/B014RRSWXI/ref=sr_1_2?ie=UTF8&qid=1485706580&sr=8-2&keywords=raquette+tennis",
                
            ),
            array(
                "setLibelle" => "Wilson federer allroundschläger wRT324800 3 rouge",
                "setDescription" => "loremipsum",
                "setCreatedBy" => $admin,
                "setCategorieProduit" => $raquetteTennis,
                "setFileProduits" => 4,
                "setPrix" => 34.99,
                "setUrl" => "https://www.amazon.fr/Wilson-federer-allroundschl%C3%A4ger-wRT324800-rouge/dp/B00SC4CD1A/ref=sr_1_1?ie=UTF8&qid=1485706580&sr=8-1&keywords=raquette+tennis",
            ),
            array(
                "setLibelle" => "Venum Contender Gants de boxe",
                "setDescription" => "loremipsum",
                "setCreatedBy" => $admin,
                "setCategorieProduit" => $gantDeBoxe,
                "setFileProduits" => 5,
                "setPrix" => 25.50,
                "setUrl" => "https://www.amazon.fr/Venum-Contender-Gants-boxe-Gris/dp/B014GVIJB0/ref=sr_1_11?ie=UTF8&qid=1485706482&sr=8-11&keywords=gant+de+boxe",
            ),
            array(
                "setLibelle" => "adidas Gants de boxe Speed 50, noir",
                "setDescription" => "loremipsum",
                "setCreatedBy" => $admin,
                "setCategorieProduit" => $gantDeBoxe,
                "setFileProduits" => 6,
                "setPrix" => 21.99,
                "setUrl" => "https://www.amazon.fr/adidas-Gants-boxe-Speed-ADISBG50/dp/B015WANK0E/ref=sr_1_5?ie=UTF8&qid=1485706482&sr=8-5&keywords=gant+de+boxe",
            ),
            array(
                "setLibelle" => "Metal Boxe Gants boxe",
                "setDescription" => "loremipsum",
                "setCreatedBy" => $admin,
                "setCategorieProduit" => $gantDeBoxe,
                "setFileProduits" => 7,
                "setPrix" => 12.99,
                "setUrl" => "https://www.amazon.fr/Metal-Boxe-PB480-Gants-boxe/dp/B00NIQPTOK/ref=sr_1_2?ie=UTF8&qid=1485706482&sr=8-2&keywords=gant+de+boxe",
            )
        );

        
        $tabKimono = array();
        // pousse une tableau de kimono
        for ($i=0; $i < 14 ; $i++) {
            $oneTab = array(
                "setLibelle" => "kimono adidas".$i,
                "setDescription" => "loremipsum",
                "setCreatedBy" => $teddy,
                "setCategorieProduit" => $kimono,
                "setFileProduits" => 1,
                "setPrix" => 56.00,
                "setUrl" => "https://www.amazon.fr/Noris-Kimono-comp%C3%A9tition-Couleur-Taille/dp/B007XTCIII/ref=sr_1_2?ie=UTF8&qid=1485706676&sr=8-2&keywords=kimono+homme+judo",
            );
            array_push($fixtures, $oneTab);
        }

        return $fixtures;
    }
    /**
     * createFileProduit enfonction de la key
     * @param  Integer $key
     * @return FileProduit
     */
    public function createFileProduit($key) {
        $fileProduit = null;
        switch ($key) {
            case 1:
                $fileProduit = new FileProduit();
                $fileProduit->setNomFichier('adidas_kimono_judo.jpg');
                $fileProduit->setTypeFichier('jpeg');
                $fileProduit->setOriginalFichier('adidas_kimono_judo.jpg');
                break;
            case 2:
                $fileProduit = new FileProduit();
                $fileProduit->setNomFichier('adidas_speed_boxe.jpg');
                $fileProduit->setTypeFichier('jpeg');
                $fileProduit->setOriginalFichier('adidas_speed_boxe.jpg');
                break;

            case 3:
                $fileProduit = new FileProduit();
                $fileProduit->setNomFichier('kimono_norris.jpg');
                $fileProduit->setTypeFichier('jpeg');
                $fileProduit->setOriginalFichier('kimono_norris.jpg');
                break;
            case 4:
                $fileProduit = new FileProduit();
                $fileProduit->setNomFichier('metal_boxe.jpg');
                $fileProduit->setTypeFichier('jpeg');
                $fileProduit->setOriginalFichier('metal_boxe.jpg');
                break;
            case 5:
                $fileProduit = new FileProduit();
                $fileProduit->setNomFichier('raquette_babola.jpg');
                $fileProduit->setTypeFichier('jpeg');
                $fileProduit->setOriginalFichier('raquette_babola.jpg');
                break;
            case 6:
                $fileProduit = new FileProduit();
                $fileProduit->setNomFichier('venum_boxe.jpg');
                $fileProduit->setTypeFichier('jpeg');
                $fileProduit->setOriginalFichier('venum_boxe.jpg');
                break;
            case 7:
                $fileProduit = new FileProduit();
                $fileProduit->setNomFichier('wilson_federer.jpg');
                $fileProduit->setTypeFichier('jpeg');
                $fileProduit->setOriginalFichier('wilson_federer.jpg');
                break;
        }

        return $fileProduit;
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