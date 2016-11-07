<?php
namespace Ath\UserBundle\Security\Core\User;

use FOS\UserBundle\Model\UserInterface as FOSUserInterface;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use FOS\UserBundle\Model\UserManagerInterface;
use Ath\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class MyOAuthProvider extends FOSUBUserProvider
{
    private $em;
    private $container;

    public function __construct(UserManagerInterface $userManager, Array $properties, ObjectManager $em, $container)
    {
        $this->em=$em;
        $this->container = $container;

        parent::__construct($userManager, $properties);
    }
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $providerName = $response->getResourceOwner()->getName();

        // Updating user by source
        switch ($providerName) {
            case 'facebook':
                $user = $this->handleFacebookResponse($response);
                break;
            /*case 'google':
                $user = $this->handleGoogleResponse($response);
                break;*/
            case 'twitter':
                $user = $this->handleTwitterResponse($response);
                break;
            case 'google':
                $user = $this->handleGoogleResponse($response);
                break;
        }
       
      /*  var_dump($response->getResourceOwner());
        var_dump($result);
        var_dump($username);
        var_dump($email);
        var_dump($providerName);
        die();*/

        $email = $user->getEmail();
        return $this->loadUserByUsername($email);
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $providerName = $response->getResourceOwner()->getName();
        $uniqueId = $response->getUsername();
        $user->addOAuthAccount($providerName, $uniqueId);

        $this->userManager->updateUser($user);
    }

    /**
     * Ad-hoc creation of user
     *
     * @param UserResponseInterface $response
     *
     * @return User
     */
    protected function createUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = $this->userManager->createUser();
        $this->updateUserByOAuthUserResponse($user, $response);

        // set default values taken from OAuth sign-in provider account
        if (null !== $email = $response->getEmail()) {
            $user->setEmail($email);
        }

        if (null === $this->userManager->findUserByUsername($response->getNickname())) {
            $user->setUsername($response->getNickname());
        }

        $user->setEnabled(true);

        return $user;
    }

    /**
     * Attach OAuth sign-in provider account to existing user
     *
     * @param FOSUserInterface      $user
     * @param UserResponseInterface $response
     *
     * @return FOSUserInterface
     */
    protected function updateUserByOAuthUserResponse(FOSUserInterface $user, UserResponseInterface $response)
    {
        $providerName = $response->getResourceOwner()->getName();
        $providerNameSetter = 'set'.ucfirst($providerName).'Id';
        $user->$providerNameSetter($response->getUsername());

        if(!$user->getPassword()) {
            // generate unique token
            $secret = md5(uniqid(rand(), true));
            $user->setPassword($secret);
        }

        return $user;
    }

    public function handleFacebookResponse($response) {
        // User is from Facebook : DO STUFF HERE \o/
        // All data from Facebook
        $token = $response->getAccessToken();
        $tabResponse = $response->getResponse();
        
        $facebookId =  $tabResponse['id']; // Facebook ID, e.g. 537091253102004
        $prenom = $tabResponse['first_name'];
        $nom = $tabResponse['last_name'];
        $gender = $tabResponse['gender'];

        $email = $response->getEmail();
        
        // search user in database
        $user = $this->userManager->findUserBy(
            array(
                'email' => $email
            )
        );

        if(!$user) {
            $user = new User();
            $user->setFacebookId($facebookId);
            $user->setEmail($email);
            $user->setEnabled(1);
            $user->addRole('ROLE_USER');
            $user->setNom($nom);
            $user->setPrenom($prenom);
            if($gender == "male")
                $user->setStatutJuridique(0);
            else
                $user->setStatutJuridique(1);
            
            $secret = md5(uniqid(rand(), true));
            $user->setPassword($secret);
            $this->em->persist($user);
            $this->em->flush();

            $sendMail = $this->container->get('ath_main.services.send_mail');

            $sendMail->registrationBySocialNetwork($user);
        }

        // His profile image : file_get_contents('https://graph.facebook.com/' . $response->getUsername() . '/picture?type=large')
 
        return $user;
    }
    
    public function handleGoogleResponse($response) {
        $tabResponse = $response->getResponse();
        $googleId =  $tabResponse['id']; // Facebook ID, e.g. 537091253102004
        $prenom = $tabResponse['given_name'];
        $nom = $tabResponse['family_name'];
        $gender = $tabResponse['gender'];  

        $email = $response->getEmail();
        
        // search user in database
        $user = $this->userManager->findUserBy(
            array(
                'email' => $email
            )
        );
        
        if(!$user) {
            $user = new User();
            $user->setGoogleId($googleId);
            $user->setEmail($email);
            $user->setEnabled(1);
            $user->addRole('ROLE_USER');
            $user->setNom($nom);
            $user->setPrenom($prenom);
            if($gender == "male")
                $user->setStatutJuridique(0);
            else
                $user->setStatutJuridique(1);
            
            $secret = md5(uniqid(rand(), true));
            $user->setPassword($secret);
            $this->em->persist($user);
            $this->em->flush();
            $sendMail = $this->container->get('ath_main.services.send_mail');
            $sendMail->registrationBySocialNetwork($user);
        }
 
        return $user;
    }
    
    public function handleTwitterResponse($response) {
        /*$token = $response->getAccessToken();
        $tabResponse = $response->getResponse();
        
        $facebookId =  $tabResponse['id']; // Facebook ID, e.g. 537091253102004
        $prenom = $tabResponse['first_name'];
        $nom = $tabResponse['last_name'];
        $gender = $tabResponse['gender'];*/

        $email = $response->getEmail();
        
        // search user in database
        $user = $this->userManager->findUserBy(
            array(
                'email' => $email
            )
        );
        var_dump($response);
        // var_dump($twitter);
        die();
        if(!$user) {
            /*$user = new User();
            $user->setFacebookId($facebookId);
            $user->setEmail($email);
            $user->setEnabled(1);
            $user->addRole('ROLE_USER');
            $user->setNom($nom);
            $user->setPrenom($prenom);
            if($gender == "male")
                $user->setStatutJuridique(0);
            else
                $user->setStatutJuridique(1);
            
            $secret = md5(uniqid(rand(), true));
            $user->setPassword($secret);
            $this->em->persist($user);
            $this->em->flush();*/
        }
 
        return $user;
    }
}