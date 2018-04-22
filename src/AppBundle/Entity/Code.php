<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Code
 *
 * @ORM\Table(name="code")
 * @ORM\Entity
 */
class Code
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomCode", type="string", length=60, nullable=true)
     */
    private $nomCode;

    /**
     * @var string
     *
     * @ORM\Column(name="codeAlloue", type="string", length=50, nullable=true)
     */
    private $codeAlloue;

    /**
     * @var Fiche
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fiche", inversedBy="code")
     */
    private $fiche;

    ///////////////// ***********************************       GETTERS AND SETTERS                ***************************//


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomCode
     *
     * @param string $nomCode
     *
     * @return Code
     */
    public function setNomCode($nomCode)
    {
        $this->nomCode = $nomCode;

        return $this;
    }

    /**
     * Get nomCode
     *
     * @return string
     */
    public function getNomCode()
    {
        return $this->nomCode;
    }

    /**
     * Set codeAlloue
     *
     * @param string $codeAlloue
     *
     * @return Code
     */
    public function setCodeAlloue($codeAlloue)
    {
        $this->codeAlloue = $codeAlloue;

        return $this;
    }

    /**
     * Get codeAlloue
     *
     * @return string
     */
    public function getCodeAlloue()
    {
        return $this->codeAlloue;
    }

    /**
     * @return Fiche
     */
    public function getFiche()
    {
        return $this->fiche;
    }

    /**
     * @param Fiche $fiche
     */
    public function setFiche($fiche)
    {
        $this->fiche = $fiche;
    }



}

