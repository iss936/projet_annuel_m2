<?php

namespace Ath\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword as OldUserPassword;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (class_exists('Symfony\Component\Security\Core\Validator\Constraints\UserPassword')) {
            $constraint = new UserPassword();
        }

        $builder->add('new', 'repeated', array(
            'type'            => 'password',
            'first_options'   => array('label' => 'Mot de passe'),
            'second_options'  => array('label' => 'Confirmer mot de passe'),
            'invalid_message' => 'Mot de passe invalide',
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ath\UserBundle\Form\Model\ChangePassword',
            'translation_domain' => 'admin',
            'intention'  => 'change_password',
        ));
    }

    public function getName()
    {
        return 'change_password';
    }
}
