<?php

namespace Ath\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DatavisualisationController extends Controller
{
    public function userAction()
    {

    	$var1 = array();
    	$sql = "select * from user";
		$t = $this->getCollections($sql);

		var_dump($t);
		die();

        return $this->render('@ath_admin_path/Datavisualisation/user.html.twig', array(
        	'var1' => $var1
        	));
    }

    private function getCollections($sql){
    	$em = $this->getDoctrine()->getManager();
		$connexion = $em->getConnection();
		$statement = $connexion->prepare($sql);
		$results = $statement->execute();
		$results = $statement->fetchAll();
		return $results;
	}
}