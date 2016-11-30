<?php

namespace Ath\MainBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Ath\MainBundle\Model\StatutDemandeCelebrite;

class StatutDemandeCelebriteDataTransformer implements DataTransformerInterface
{
    /**
     * Transforms a string to an array => Bdd to Application (getSatut retourne un string dans entity).
     * 
     * @param string
     * @return array
     */
    public function transform($statut)
    {

        if(!empty($statut))
        {
            $arrayStatut = array($statut => StatutDemandeCelebrite::getIdFromLib($statut));
        }
        else
            return;

        return $arrayStatut;
    }

    /**
     * Transforms an array to an integer => application to Bdd
     *
     * @param  Array $statuts
     *
     * @return String $statuts
     */
    public function reverseTransform($statuts)
    {
        $allStatuts = StatutDemandeCelebrite::getAll();

        if (array_key_exists($statuts['statuts'], $allStatuts))
        {
            $statuts = $statuts['statuts'];
        }
        else
             throw new TransformationFailedException("La clé est introuvable");

        return $statuts;
    }
}
