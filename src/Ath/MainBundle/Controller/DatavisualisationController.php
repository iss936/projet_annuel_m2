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
		$nombreHomme = $this->getCollections("SELECT COUNT(*) as nombre FROM user where statut_juridique = 1");
		$nombreFemme = $this->getCollections("SELECT COUNT(*) as nombre FROM user where statut_juridique = 2");
		$nombreAssociation = $this->getCollections("SELECT COUNT(*) as nombre FROM user where statut_juridique = 3");
		$nombreUsers = $this->getCollections("SELECT COUNT(*) as nombre FROM user");
		$postsByUsers = $this->getCollections("SELECT post.id, COUNT(*) as nombre, user.statut_juridique FROM post, user where user.id = post.created_by group by created_by");	
							
		$association = ["moyenne" => "",
						"total" => 0];
		
		$homme = ["moyenne" => "",
						"total" => 0];
						
		$femme = ["moyenne" => "",
						"total" => 0];
						
		$nombrePostFemme = 0;
		$nombrePostHomme = 0;
		$nombrePostAssociation = 0;
		
		foreach($postsByUsers as $key => $value){
			switch($value["statut_juridique"]){
				case (1):
					$nombrePostHomme++;
					$homme["total"] += $value["nombre"]; 
				break;
				
				case (2):
					$nombrePostFemme++;
					$femme["total"] += $value["nombre"]; 
				break; 
				
				case (3):
					$nombrePostAssociation++;
					$association["total"] += $value["nombre"]; 
				break;				
			}
		}
		
		if ($nombrePostAssociation == 0) $nombrePostAssociation = 1;
		if ($nombrePostFemme == 0) $nombrePostFemme = 1;
		if ($nombrePostHomme == 0) $nombrePostHomme = 1;
		
		$association["moyenne"] = $association["total"]/$nombrePostAssociation;
		$homme["moyenne"] = $homme["total"]/$nombrePostHomme;
		$femme["moyenne"] = $femme["total"]/$nombrePostFemme;
		
        return $this->render('@ath_admin_path/Datavisualisation/user.html.twig', array(
        	'nombreFemme' => $nombreFemme,
			'nombreHomme' => $nombreHomme,
			'nombreAssociation' => $nombreAssociation,
			'homme' => $homme,
			'femme' => $femme,
			'association' => $association
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