<?php

namespace Ath\UserBundle\Tests\Entity;

use Ath\MainBundle\Tests\WebTestCase;
use Ath\UserBundle\Entity\User;
use Ath\MainBundle\Entity\DemandeCelebrite;


class UserTest extends WebTestCase
{
	protected $em;

    public function __construct()
    {
        $em = static::getManagerStatic();
        $this->em = $em;
    }

	public function testGetNomComplet()
	{
		$user = $this->em->getRepository('AthUserBundle:User')->findOneByUsername('soumare.iss@gmail.com');
		
		$nomComplet = $user->getNomComplet();

		$this->assertEquals('Super Admin', $nomComplet);
	}


	public function testGetAdresse()
	{
		$user = $this->em->getRepository('AthUserBundle:User')->findOneByUsername('soumare.iss@gmail.com');
		
		$adresse = $user->getAdresse();

		$this->assertEquals('3 place des lotus 93600 Aulnay-Sous-Bois', $adresse);
	}

	public function testGetPrefixMail()
	{
		$user = $this->em->getRepository('AthUserBundle:User')->findOneByUsername('soumare.iss@gmail.com');
		
		$mail = $user->getPrefixMail($user->getUsername());

		$this->assertEquals('soumare.iss', $mail);
	}

	public function testHasRole()
	{
		// tous les droits
		$superAdmin = $this->em->getRepository('AthUserBundle:User')->findOneByUsername('soumare.iss@gmail.com');
		$this->assertTrue($superAdmin->hasRole('ROLE_CELEBRITE'));
		$this->assertTrue($superAdmin->hasRole('ROLE_ADMIN'));

		// que le droit user
		$user = $this->em->getRepository('AthUserBundle:User')->findOneByUsername('john@gmail.com');
		$this->assertFalse($user->hasRole('ROLE_CELEBRITE'));
		$this->assertFalse($user->hasRole('ROLE_ADMIN'));
		$this->assertFalse($user->hasRole('ROLE_ASSOC'));
		$this->assertTrue($user->hasRole('ROLE_USER'));
	}

	public function testCanDemandeCelebrite()
	{
		$superAdmin = $this->em->getRepository('AthUserBundle:User')->findOneByUsername('soumare.iss@gmail.com');

		$this->assertFalse($superAdmin->canDemandeCelebrite());

		// aucune demande de célébrité de fait le user peut créer une demande célébrité
		$user = $this->em->getRepository('AthUserBundle:User')->findOneByUsername('john@gmail.com');
		$this->assertTrue($user->canDemandeCelebrite());

		$demandeCelebrite = new DemandeCelebrite();
		$demandeCelebrite->setContenu('coucou');
		$demandeCelebrite->setDateDemande(new \DateTime());
		$demandeCelebrite->setCreatedBy($user);
		$user->addDemandeCelebrite($demandeCelebrite);
	
		// le user a une demande de célébrité de créer aujourd'hui il ne peut en faire avant 30 jours 
		$this->assertFalse($user->canDemandeCelebrite());

		// L'assoc ne peut absolument pas faire une demande de célébrité
		$assoc = $this->em->getRepository('AthUserBundle:User')->findOneByUsername('redstar@gmail.com');
		$this->assertFalse($assoc->canDemandeCelebrite());


	}
}