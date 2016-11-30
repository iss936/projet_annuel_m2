<?php

namespace Ath\MainBundle\Model;

/**
* Les status d'une demande de célébrité
*/
class StatutDemandeCelebrite
{
    protected static $statuts = array(
        ''  => '',
        '1' => 'En Cours',
        '2' => 'Accepter',
        '3' => 'Refuser',
    );

    /**
     * GetAll
     *
     * @return array()
     */
    public static function getAll(){
        return self::$statuts;
    }

    /**
     * getLibFromId
     *
     * @param integer id
     * @return string
     */
    public static function getLibFromId($id){
        if ($id != NULL) {
            $tab = self::$statuts;
            return $tab[$id];
        }
        else{
            return '';
        }
    }

    /**
     * get IdFromLib
     *
     * @param string value
     * @return integer id
     */
    public static function getIdFromLib($value){
        if ($value != NULL) {
            $tab = self::$statuts;
            $id = array_search($value, $tab);
            return $id;
        }
        else{
            return '';
        }
    }

}
