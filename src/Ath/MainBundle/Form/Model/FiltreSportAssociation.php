<?php

namespace Ath\MainBundle\Form\Model;

class FiltreSportAssociation
{
    /**
     * @var string
     */
    public $sports;

    /**
     * Gets the value of sports.
     *
     * @return string
     */
    public function getSports()
    {
        return $this->sports;
    }

    /**
     * Sets the value of sports.
     *
     * @param string $sports the sports
     *
     * @return self
     */
    public function setSports($sports)
    {
        $this->sports = $sports;

        return $this;
    }
}
