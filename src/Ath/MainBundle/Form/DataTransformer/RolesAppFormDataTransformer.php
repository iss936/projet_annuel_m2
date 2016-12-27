<?php

namespace Ath\MainBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class RolesAppFormDataTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array to a string.
     * POSSIBLE LOSS OF DATA
     *
     * @return string
     */
    public function transform($array)
    {
        if (empty($array)) {
            return $array;
        }

        $newArray = array();
        $newArray["roles"] = $array;

        return $newArray;
    }

    /**
     * Transforms a string to an array.
     *
     * @param  string $string
     *
     * @return array
     */
    public function reverseTransform($array)
    {

        //var_dump($string);
        $aRoles = array();
        foreach ($array as $allValue) {
            foreach ($allValue as $value) {
                $aRoles[] = $value;
            }
        }
        return $aRoles;
    }
}
