<?php

namespace Ath\MainBundle\Form\Model;

class FiltreCategorieProduit
{
    /**
     * @var string
     */
    public $categorieProduit = array();

    /**
     * Gets the value of categorie produit.
     *
     * @return string
     */
    public function getCategorieProduit()
    {
        return $this->categorieProduit;
    }

    /**
     * Sets the value of categorie produit.
     *
     * @param string $categorieProduit The categorie of produit
     *
     * @return self
     */
    public function setSports($categorieProduit)
    {
        $this->categorieProduit = $categorieProduit;

        return $this;
    }
}
