<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Filaire
 *
 * @ORM\Table(name="filaire")
 * @ORM\Entity
 */
class Filaire
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
     *      max =80)
     * @ORM\Column(name="adresseIP", type="string", length=80, nullable=true)
     */
    private $adresseip;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =60)
     * @ORM\Column(name="GSM", type="string", length=60, nullable=true)
     */
    private $gsm;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IPfixe", type="boolean", nullable=true)
     */
    private $ipfixe;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="portSPC", type="string", length=50, nullable=true)
     */
    private $portspc;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="portSortant", type="string", length=50, nullable=true)
     */
    private $portsortant;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="portWeb", type="string", length=50, nullable=true)
     */
    private $portweb;

    /**
     * @var string
     *
     * @ORM\Column(name="mdpWeb", type="string", length=200, nullable=true)
     */
    private $mdpweb;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="FAI", type="string", length=50, nullable=true)
     */
    private $fai;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="cleCryptage", type="string", length=50, nullable=true)
     */
    private $clecryptage;

    /**
     * @var string
     *
     * @ORM\Column(name="gestionHoraire", type="text", length=255, nullable=true)
     */
    private $gestionhoraire;

    /**
     * @var boolean
     *
     * @ORM\Column(name="GMESappel", type="boolean", nullable=true)
     */
    private $gmesappel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="MESauto", type="boolean", nullable=true)
     */
    private $mesauto;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =30)
     * @ORM\Column(name="operateur_sim", type="string", length=30, nullable=true)
     */
    private $operateurSim;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="num_carte_sim", type="string", length=50, nullable=true)
     */
    private $numCarteSim;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="num_voix", type="string", length=50, nullable=true)
     */
    private $numVoix;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="num_data", type="string", length=50, nullable=true)
     */
    private $numData;

	/**
	 * @var string
	 * @Assert\Length(
	 *      min = 2,
	 *      max =50)
	 * @ORM\Column(name="rep_ptt", type="string", length=50, nullable=true)
	 */
	private $rep_ptt;

	/**
	 * @var string
	 * @Assert\Length(
	 *      min = 2,
	 *      max =50)
	 * @ORM\Column(name="coupe_sirene", type="string", length=50, nullable=true)
	 */
	private $coupe_sirene;

	/**
	 * @var string
	 * @Assert\Length(
	 *      min = 2,
	 *      max =50)
	 * @ORM\Column(name="chargeur", type="string", length=50, nullable=true)
	 */
	private $chargeur;

	/**
	 * @var string
	 * @Assert\Length(
	 *      min = 2,
	 *      max =50)
	 * @ORM\Column(name="transpondeur", type="string", length=50, nullable=true)
	 */
	private $transpondeur;



	/**
     * @var \AppBundle\Entity\Fiche
     *
     * @ORM\OneToOne(targetEntity="Fiche", mappedBy="filaire", cascade={"persist"})
     */
    private $fiche;



    ///////////////// ***********************************       GETTERS AND SETTERS                ***************************//


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

    /**
     * @return string
     */
    public function getAdresseip()
    {
        return $this->adresseip;
    }

    /**
     * @param string $adresseip
     */
    public function setAdresseip($adresseip)
    {
        $this->adresseip = $adresseip;
    }

    /**
     * @return string
     */
    public function getGsm()
    {
        return $this->gsm;
    }

    /**
     * @param string $gsm
     */
    public function setGsm($gsm)
    {
        $this->gsm = $gsm;
    }

    /**
     * @return bool
     */
    public function isIpfixe()
    {
        return $this->ipfixe;
    }

    /**
     * @param bool $ipfixe
     */
    public function setIpfixe($ipfixe)
    {
        $this->ipfixe = $ipfixe;
    }

    /**
     * @return string
     */
    public function getPortspc()
    {
        return $this->portspc;
    }

    /**
     * @param string $portspc
     */
    public function setPortspc($portspc)
    {
        $this->portspc = $portspc;
    }

    /**
     * @return string
     */
    public function getPortsortant()
    {
        return $this->portsortant;
    }

    /**
     * @param string $portsortant
     */
    public function setPortsortant($portsortant)
    {
        $this->portsortant = $portsortant;
    }

    /**
     * @return string
     */
    public function getPortweb()
    {
        return $this->portweb;
    }

    /**
     * @param string $portweb
     */
    public function setPortweb($portweb)
    {
        $this->portweb = $portweb;
    }

    /**
     * @return string
     */
    public function getMdpweb()
    {
        return $this->mdpweb;
    }

    /**
     * @param string $mdpweb
     */
    public function setMdpweb($mdpweb)
    {
        $this->mdpweb = $mdpweb;
    }

    /**
     * @return string
     */
    public function getFai()
    {
        return $this->fai;
    }

    /**
     * @param string $fai
     */
    public function setFai($fai)
    {
        $this->fai = $fai;
    }

    /**
     * @return string
     */
    public function getClecryptage()
    {
        return $this->clecryptage;
    }

    /**
     * @param string $clecryptage
     */
    public function setClecryptage($clecryptage)
    {
        $this->clecryptage = $clecryptage;
    }

    /**
     * @return string
     */
    public function getGestionhoraire()
    {
        return $this->gestionhoraire;
    }

    /**
     * @param string $gestionhoraire
     */
    public function setGestionhoraire($gestionhoraire)
    {
        $this->gestionhoraire = $gestionhoraire;
    }

    /**
     * @return bool
     */
    public function isGmesappel()
    {
        return $this->gmesappel;
    }

    /**
     * @param bool $gmesappel
     */
    public function setGmesappel($gmesappel)
    {
        $this->gmesappel = $gmesappel;
    }

    /**
     * @return bool
     */
    public function isMesauto()
    {
        return $this->mesauto;
    }

    /**
     * @param bool $mesauto
     */
    public function setMesauto($mesauto)
    {
        $this->mesauto = $mesauto;
    }

    /**
     * @return string
     */
    public function getOperateurSim()
    {
        return $this->operateurSim;
    }

    /**
     * @param string $operateurSim
     */
    public function setOperateurSim($operateurSim)
    {
        $this->operateurSim = $operateurSim;
    }

    /**
     * @return string
     */
    public function getNumCarteSim()
    {
        return $this->numCarteSim;
    }

    /**
     * @param string $numCarteSim
     */
    public function setNumCarteSim($numCarteSim)
    {
        $this->numCarteSim = $numCarteSim;
    }

    /**
     * @return string
     */
    public function getNumVoix()
    {
        return $this->numVoix;
    }

    /**
     * @param string $numVoix
     */
    public function setNumVoix($numVoix)
    {
        $this->numVoix = $numVoix;
    }

    /**
     * @return string
     */
    public function getNumData()
    {
        return $this->numData;
    }

    /**
     * @param string $numData
     */
    public function setNumData($numData)
    {
        $this->numData = $numData;
    }

	/**
	 * @return string
	 */
	public function getRepPtt(): string {
		return $this->rep_ptt;
	}

	/**
	 * @param string $rep_ptt
	 */
	public function setRepPtt( string $rep_ptt ) {
		$this->rep_ptt = $rep_ptt;
	}

	/**
	 * @return string
	 */
	public function getCoupeSirene(): string {
		return $this->coupe_sirene;
	}

	/**
	 * @param string $coupe_sirene
	 */
	public function setCoupeSirene( string $coupe_sirene ) {
		$this->coupe_sirene = $coupe_sirene;
	}

	/**
	 * @return string
	 */
	public function getChargeur(): string {
		return $this->chargeur;
	}

	/**
	 * @param string $chargeur
	 */
	public function setChargeur( string $chargeur ) {
		$this->chargeur = $chargeur;
	}

	/**
	 * @return string
	 */
	public function getTranspondeur(): string {
		return $this->transpondeur;
	}

	/**
	 * @param string $transpondeur
	 */
	public function setTranspondeur( string $transpondeur ) {
		$this->transpondeur = $transpondeur;
	}




}

