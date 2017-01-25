<?php

namespace Ath\MainBundle\Form\Model;

class FiltreCategorieProduit
{
    /**
     * @var string
     */
    public $categorieProduit = array();

    /**
     * @var string
     */
    public $prix = array();

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
    public function setCategorieProduit($categorieProduit)
    {
        $this->categorieProduit = $categorieProduit;

        return $this;
    }

    /**
     * Gets the value of categorie produit.
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Sets the value of categorie produit.
     *
     * @param string $categorieProduit The categorie of produit
     *
     * @return self
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }
}