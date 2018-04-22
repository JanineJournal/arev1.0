<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;


/**
 * Fiche
 *
 * @ORM\Table(name="fiche")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FicheRepository")
 */
class Fiche
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     * @Assert\Length(
     *      min = 1,
     *      max = 20)
     * @ORM\Column(name="codeRacco", type="integer", nullable=false)
     */
    private $coderacco;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_old", type="integer", nullable=true)
     */
    private $id_old;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 50)
     * @ORM\Column(name="programmation", type="string", length=50, nullable=true)
     */
    private $programmation;

    /**
     * @var string
     * @Assert\Length(
     *      min =3,
     *      max = 50)
     * @ORM\Column(name="statut", type="string", length=50, nullable=true)
     */
    private $statut;

    /**
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max = 50)
     * @ORM\Column(name="intervention", type="string", length=50, nullable=true)
     */
    private $intervention;

    /**
     * @var string
     * @Assert\Length(
     *      min = 5,
     *      max = 55)
     * @ORM\Column(name="operateurTP", type="string", length=55, nullable=true)
     */
    private $operateurtp;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 50)
     * @ORM\Column(name="centreTSV", type="string", length=50, nullable=true)
     */
    private $centretsv;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 50)
     * @ORM\Column(name="TSVsecours", type="string", length=50, nullable=true)
     */
    private $tsvsecours;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 50)
     * @ORM\Column(name="mdpClient", type="string", length=50, nullable=true)
     */
    private $mdpclient;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 20)
     * @ORM\Column(name="num_commande", type="string", length=20, nullable=true)
     */
    private $numCommande;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 50)
     * @ORM\Column(name="technicien", type="string", length=50, nullable=true)
     */
    private $technicien;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaireTP", type="text", nullable=true)
     */
    private $commentairetp;

   /**
     * @var string
    * @Assert\Length(
    *      min = 2,
    *      max =50)
     * @ORM\Column(name="type_centrale", type="string", length=50, nullable=true)
     */
    private $typeCentrale;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =40)
     * @ORM\Column(name="reference_centrale", type="string", length=40, nullable=true)
     */
    private $referenceCentrale;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =40)
     * @ORM\Column(name="localisation_centrale", type="string", length=40, nullable=true)
     */
    private $localisationCentrale;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =88)
     * @ORM\Column(name="NS_Centrale", type="string", length=88, nullable=true)
     */
    private $numserieCentrale;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="version", type="string", length=50, nullable=true)
     */
    private $version;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =50)
     * @ORM\Column(name="firmware", type="string", length=50, nullable=true) // logiciel
     */
    private $firmware;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =20)
     * @ORM\Column(name="prom", type="string", length=20, nullable=true) //puce
     */
    private $prom;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max =20)
     * @ORM\Column(name="masque", type="string", length=20, nullable=true)
     */
    private $masque;

    ///////////////// ***********************************       ONE TO ONE                ***************************//


    /**
     * @OneToOne(targetEntity="Appsmartphone", mappedBy="fiche", cascade={"persist"})
     */
    private $appsmartphone;

    /**
     * @OneToOne(targetEntity="Radio", inversedBy="fiche", cascade={"persist"})
     *
     */
    private $radio;

    /**
     * @OneToOne(targetEntity="Filaire", inversedBy="fiche", cascade={"persist"})
     *
     */
    private $filaire;


    ///////////////// ***********************************      MANY TO ONE               ***************************//

    /**
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="fiche", cascade={"persist"})
     */
    private $site;

    ///////////////// ***********************************       ONE TO MANY                ***************************//

    /**
     * @OneToMany(targetEntity="InterTP", mappedBy="fiche", cascade="all", orphanRemoval=true)
     */
    private $interTP;

    /**
     * @OneToMany(targetEntity="Habilite", mappedBy="fiche", cascade="all", orphanRemoval=true)
     */
    private $habilite;

    /**
     * @OneToMany(targetEntity="Code", mappedBy="fiche", cascade="all", orphanRemoval=true)
     */
    private $code;

    /**
     * @OneToMany(targetEntity="Secteur", mappedBy="fiche", cascade="all", orphanRemoval=true)
     */
    private $secteur;


    ///////////////// ***********************************       constructeur                ***************************//

    public function __construct()
    {
        $this->date = new \Datetime();
        $this->secteur = new ArrayCollection();
        $this->habilite = new ArrayCollection();
        $this->code = new ArrayCollection();
        $this->interTP = new ArrayCollection();
    }

    /********************************************    FONCTIONS ******************************************/

    public function __toString()
    {
        $code = "Code Racco : " . $this->coderacco . " - ID fiche : " . $this->id;
        return $code;
    }

    ///////////////// ***********************************       GETTERS AND SETTERS                ***************************//


    /**
     * @return mixed
     */
    public function getAppsmartphone()
    {
        return $this->appsmartphone;
    }

    /**
     * @param mixed $appsmartphone
     */
    public function setAppsmartphone($appsmartphone)
    {
        $this->appsmartphone = $appsmartphone;
        $appsmartphone->setFiche($this);

    }

    /**
     * @return mixed
     */
    public function getFilaire()
    {
        return $this->filaire;
    }

    /**
     * @param mixed $filaire
     */
    public function setFilaire($filaire)
    {
        $this->filaire = $filaire;
        $filaire->setFiche($this);
    }

    /**
     * Add code
     * @param Code $code
     *
     */
    public function addCode(Code $code)
    {
        if (!$code->getNomCode() == null) {
            $code->setFiche($this);
            $this->code[] = $code;
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param Code $code
     */
    public function removeCode(Code $code)
    {
        $this->code->removeElement($code);
    }

    /**
     * @return ArrayCollection
     */
    public function getHabilite()
    {
        return $this->habilite;
    }

    /**
     * Add habilite
     *
     * @param Habilite $habilite
     * @return Fiche
     */
    public function addHabilite(Habilite $habilite)
    {
        if (!$habilite->getNomhabili() == null & !$habilite->getTypehabili() == null & !$habilite->getNumtel() == null) {
            $this->habilite[] = $habilite;
            $habilite->setFiche($this);
        }
        return $this;
    }

    /**
     * @param mixed $habilite
     */
    public function setHabilite($habilite)
    {
        $this->habilite = $habilite;
    }

    public function removeHabilite(Habilite $habilite)
    {
        $this->habilite->removeElement($habilite);
    }

    /**
     * @return ArrayCollection
     */
    public function GetSecteur()
    {
        return $this->secteur;
    }

    /**
     * Add Secteur
     *
     * @param Secteur $secteur
     * @return Fiche
     */
    public function addSecteur(Secteur $secteur)
    {
        if (!$secteur->getNom() == null) {
            $secteur->setFiche($this);
            $this->secteur[] = $secteur;
        }
        return $this;
    }

    /**
     * @param Secteur $secteur
     */
    public function removeSecteur(Secteur $secteur)
    {
        $this->secteur->removeElement($secteur);
    }

    /**
     * @param mixed $secteur
     */
    public function setSecteur($secteur)
    {
        $this->secteur = $secteur;

    }

    /**
     * @return string
     */
    public function getCoderacco()
    {
        return $this->coderacco;
    }

    /**
     * @param string $coderacco
     */
    public function setCoderacco($coderacco)
    {
        $this->coderacco = $coderacco;
    }

    /**
     * @return string
     */
    public function getProgrammation()
    {
        return $this->programmation;
    }

    /**
     * @param string $programmation
     */
    public function setProgrammation($programmation)
    {
        $this->programmation = $programmation;
    }

    /**
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param string $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return string
     */
    public function getIntervention()
    {
        return $this->intervention;
    }

    /**
     * @param string $intervention
     */
    public function setIntervention($intervention)
    {
        $this->intervention = $intervention;
    }

    /**
     * @return string
     */
    public function getOperateurtp()
    {
        return $this->operateurtp;
    }

    /**
     * @param string $operateurtp
     */
    public function setOperateurtp($operateurtp)
    {
        $this->operateurtp = $operateurtp;
    }

    /**
     * @return string
     */
    public function getCentretsv()
    {
        return $this->centretsv;
    }

    /**
     * @param string $centretsv
     */
    public function setCentretsv($centretsv)
    {
        $this->centretsv = $centretsv;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getTsvsecours()
    {
        return $this->tsvsecours;
    }

    /**
     * @param string $tsvsecours
     */
    public function setTsvsecours($tsvsecours)
    {
        $this->tsvsecours = $tsvsecours;
    }

    /**
     * @return string
     */
    public function getMdpclient()
    {
        return $this->mdpclient;
    }

    /**
     * @param string $mdpclient
     */
    public function setMdpclient($mdpclient)
    {
        $this->mdpclient = $mdpclient;
    }

    /**
     * @return int
     */
    public function getNumCommande()
    {
        return $this->numCommande;
    }

    /**
     * @param int $numCommande
     */
    public function setNumCommande($numCommande)
    {
        $this->numCommande = $numCommande;
    }

    /**
     * @return string
     */
    public function getTechnicien()
    {
        return $this->technicien;
    }

    /**
     * @param string $technicien
     */
    public function setTechnicien($technicien)
    {
        $this->technicien = $technicien;
    }

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return string
     */
    public function getCommentairetp()
    {
        return $this->commentairetp;
    }

    /**
     * @param string $commentairetp
     */
    public function setCommentairetp($commentairetp)
    {
        $this->commentairetp = $commentairetp;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRadio()
    {
        return $this->radio;
    }

    /**
     * @param mixed $radio
     */
    public function setRadio($radio)
    {
        $this->radio = $radio;
        $radio->setFiche($this);
    }

    /**
     * @return mixed
     */
    public function getInterTP()
    {
        return $this->interTP;
    }

    /**
     * @param mixed $interTP
     */
    public function setInterTP($interTP)
    {
        $this->interTP = $interTP;
    }

    public function addCompteVideo($comptevid)
    {
        if ($this->getAppsmartphone()) {
            return $this->getAppsmartphone()->addCompteVideo($comptevid);
        }
    }

    public function getCompteVideo()
    {
        if ($this->getAppsmartphone()) {
            return $this->getAppsmartphone()->getCompteVideo();
        }
    }

    /**
     * Add InterTP
     *
     * @param InterTP $interTP
     * @return Fiche
     */
    public function addInterTP(InterTP $interTP)
    {
        if (!$interTP->getCommentaire() == null) {
            $this->interTP[] = $interTP;
            $interTP->setFiche($this);
        }
        return $this;
    }

    /**
     * @param  InterTP $interTP
     */
    public function removeInterTP( InterTP $interTP)
    {
        $this->interTP->removeElement($interTP);
    }

    /**
     * @return mixed
     */
    public function getTypeCentrale()
    {
        return $this->typeCentrale;
    }

    /**
     * @param mixed $typeCentrale
     */
    public function setTypeCentrale($typeCentrale)
    {
        $this->typeCentrale = $typeCentrale;
    }

    /**
     * @return mixed
     */
    public function getReferenceCentrale()
    {
        return $this->referenceCentrale;
    }

    /**
     * @param mixed $referenceCentrale
     */
    public function setReferenceCentrale($referenceCentrale)
    {
        $this->referenceCentrale = $referenceCentrale;
    }

    /**
     * @return mixed
     */
    public function getLocalisationCentrale()
    {
        return $this->localisationCentrale;
    }

    /**
     * @param mixed $localisationCentrale
     */
    public function setLocalisationCentrale($localisationCentrale)
    {
        $this->localisationCentrale = $localisationCentrale;
    }

    /**
     * @return mixed
     */
    public function getNumserieCentrale()
    {
        return $this->numserieCentrale;
    }

    /**
     * @param mixed $numserieCentrale
     */
    public function setNumserieCentrale($numserieCentrale)
    {
        $this->numserieCentrale = $numserieCentrale;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getFirmware()
    {
        return $this->firmware;
    }

    /**
     * @param mixed $firmware
     */
    public function setFirmware($firmware)
    {
        $this->firmware = $firmware;
    }

    /**
     * @return mixed
     */
    public function getProm()
    {
        return $this->prom;
    }

    /**
     * @param mixed $prom
     */
    public function setProm($prom)
    {
        $this->prom = $prom;
    }

    /**
     * @return mixed
     */
    public function getMasque()
    {
        return $this->masque;
    }

    /**
     * @param mixed $masque
     */
    public function setMasque($masque)
    {
        $this->masque = $masque;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site)
    {
        $this->site = $site;
        $site->addFiche($this);
    }





}

