<?php

namespace Ath\UserBundle\Model;

/**
* Les status juridiques d'un User
*/
class StatutJuridique
{

    protected static $statuts = array(
        // ''  => '',
        '0' => 'unHomme',
        '1' => 'uneFemme',
        '2' => 'uneAssociation',
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
