<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Peripherique
 *
 * @ORM\Table(name="peripherique")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PeripheriqueRepository")
 */
class Peripherique
{
    /**
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max = 50)
     * @ORM\Column(name="nom", type="string", length=60, nullable=true)
     */
    private $nom;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =30)
     * @ORM\Column(name="numIni", type="string", length=30, nullable=true)
     */
    private $numIni;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =30)
     * @ORM\Column(name="type", type="string", length=30, nullable=true)
     */
    private $type;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="reference", type="string", length=50, nullable=true)
     */
    private $reference;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="localisation", type="string", length=50, nullable=true)
     */
    private $localisation;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =80)
     * @ORM\Column(name="numSerie", type="string", length=80, nullable=true)
     */
    private $numserie;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =80)
     * @ORM\Column(name="version", type="string", length=80, nullable=true)
     */
    private $version;

    /**
     * @var boolean
     * @ORM\Column(name="additionnel", type="boolean", nullable=true)
     */
    private $additionnel;

    /**
     * @var \AppBundle\Entity\Secteur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Secteur", inversedBy="peripherique")
     */
    private $secteur;

    /**
     * @var string
     * @Assert\Length(
     *      max =8)
     * @ORM\Column(name="codeTransmis", type="string", length=8, nullable=true)
     */
    private $codeTransmis;

    /**
     * @var integer
     * @ORM\Column(name="idFiche", type="integer", nullable=true)
     */
    private $idFiche;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    ///////////////// ***********************************      GETTERS AND SETTERS              ***************************//


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getIdFiche()
    {
        return $this->idFiche;
    }

    /**
     * @param int $idFiche
     */
    public function setIdFiche($idFiche)
    {
        $this->idFiche = $idFiche;
    }

    /**
     * @return string
     */
    public function getNumIni()
    {
        return $this->numIni;
    }

    /**
     * @param string $numIni
     */
    public function setNumIni($numIni)
    {
        $this->numIni = $numIni;
    }

    /**
     * @return string
     */
    public function getCodeTransmis()
    {
        return $this->codeTransmis;
    }

    /**
     * @param string $codeTransmis
     */
    public function setCodeTransmis($codeTransmis)
    {
        $this->codeTransmis = $codeTransmis;
    }

    /**
     * @return bool
     */
    public function isAdditionnel()
    {
        return $this->additionnel;
    }

    /**
     * @param bool $additionnel
     */
    public function setAdditionnel($additionnel)
    {
        $this->additionnel = $additionnel;
    }
    
    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getNumserie()
    {
        return $this->numserie;
    }

    /**
     * @param string $numserie
     */
    public function setNumserie($numserie)
    {
        $this->numserie = $numserie;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param string $localisation
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;
    }


    /**
     * @return Secteur
     */
    public function getSecteur()
    {
        return $this->secteur;
    }

    /**
     * @param Secteur $secteur
     */
    public function setSecteur($secteur)
    {
        $this->secteur = $secteur;
    }

}

