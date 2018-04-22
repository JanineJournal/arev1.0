<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Habilite
 *
 * @ORM\Table(name="habilite")
 * @ORM\Entity
 */
class Habilite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max = 10)
     * @ORM\Column(name="civilite", type="string", length=10, nullable=true)
     */
    private $civilite;

    /**
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max = 50)
     * @ORM\Column(name="nomHabili", type="string", length=50, nullable=true)
     */
    private $nomhabili;

    /**
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max = 40)
     * @ORM\Column(name="prenomHabili", type="string", length=40, nullable=true)
     */
    private $prenomhabili;

    /**
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max = 40)
     * @ORM\Column(name="typeHabili", type="string", length=40, nullable=true)
     */
    private $typehabili;

    /**
     * @var string
     * @Assert\Length(
     *      min = 10,
     *      max = 20)
     * @ORM\Column(name="numTel", type="string", length=20, nullable=true)
     */
    private $numtel;

    /**
     * @var string
     * @Assert\Length(
     *      min = 10,
     *      max = 20)
     * @ORM\Column(name="numTel2", type="string", length=20, nullable=true)
     */
    private $numtel2;

    /**
     * @var string
     * @Assert\Length(
     *      min = 10,
     *      max = 20)
     * @ORM\Column(name="numTel3", type="string", length=20, nullable=true)
     */
    private $numtel3;

    /**
     * @var string
     * @Assert\Length(
     *      min = 10,
     *      max = 20)
     * @ORM\Column(name="numTel4", type="string", length=20, nullable=true)
     */
    private $numtel4;

    /**
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max = 200)
     * @ORM\Column(name="mdpHabili", type="string", length=200, nullable=true)
     */
    private $mdphabili;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fiche", inversedBy="habilite")
     */
    private $fiche;


    ///////////////// ***********************************       GETTERS AND SETTERS               ***************************//

    /**
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @param string $civilite
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
    }

    /**
     * @return string
     */
    public function getNomhabili()
    {
        return $this->nomhabili;
    }

    /**
     * @param string $nomhabili
     */
    public function setNomhabili($nomhabili)
    {
        $this->nomhabili = $nomhabili;
    }

    /**
     * @return string
     */
    public function getPrenomhabili()
    {
        return $this->prenomhabili;
    }

    /**
     * @param string $prenomhabili
     */
    public function setPrenomhabili($prenomhabili)
    {
        $this->prenomhabili = $prenomhabili;
    }

    /**
     * @return string
     */
    public function getTypehabili()
    {
        return $this->typehabili;
    }

    /**
     * @param string $typehabili
     */
    public function setTypehabili($typehabili)
    {
        $this->typehabili = $typehabili;
    }

    /**
     * @return string
     */
    public function getNumtel()
    {
        return $this->numtel;
    }

    /**
     * @param string $numtel
     */
    public function setNumtel($numtel)
    {
        $this->numtel = $numtel;
    }

    /**
     * @return string
     */
    public function getNumtel2()
    {
        return $this->numtel2;
    }

    /**
     * @param string $numtel2
     */
    public function setNumtel2($numtel2)
    {
        $this->numtel2 = $numtel2;
    }

    /**
     * @return string
     */
    public function getNumtel3()
    {
        return $this->numtel3;
    }

    /**
     * @param string $numtel3
     */
    public function setNumtel3($numtel3)
    {
        $this->numtel3 = $numtel3;
    }

    /**
     * @return string
     */
    public function getNumtel4()
    {
        return $this->numtel4;
    }

    /**
     * @param string $numtel4
     */
    public function setNumtel4($numtel4)
    {
        $this->numtel4 = $numtel4;
    }

    /**
     * @return string
     */
    public function getMdphabili()
    {
        return $this->mdphabili;
    }

    /**
     * @param string $mdphabili
     */
    public function setMdphabili($mdphabili)
    {
        $this->mdphabili = $mdphabili;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

