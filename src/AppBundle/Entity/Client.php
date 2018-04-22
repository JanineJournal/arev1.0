<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity
 */
class Client
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
     * @var integer
     *
     * @ORM\Column(name="nomClient", type="string", length=150, nullable=true)
     */
    private $nomclient;

    /**
     * @var string
     *
     * @ORM\Column(name="codeClient", type="string", nullable=true)
     */
    private $codeclient; //account_num de Custtable

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse01", type="string", length=250, nullable=true)
     */
    private $adresse01;

    /**
     * @var string
     *
     * @ORM\Column(name="codePostal", type="string", nullable=true)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="villeLocalite", type="string", length=50, nullable=true)
     */
    private $villelocalite;

    /**
     * @var string
     * @Assert\Length(
     *      min = 10,
     *      max =20)
     * @ORM\Column(name="numTel1", type="string", length=20, nullable=true)
     */
    private $numtel1;

    /**
     * @var string
     * @Assert\Length(
     *      min = 10,
     *      max =20)
     * @ORM\Column(name="numTel2", type="string", length=20, nullable=true)
     */
    private $numtel2;

    /**
     * @var string
     *
 * @ORM\Column(name="dataareaid", type="string", length=4, nullable=true)
     */
    private $dataareaid;


    /************************** ONE TO MANY **********/

    /**
     * @var \AppBundle\Entity\Site
     * @OneToMany(targetEntity="Site", mappedBy="client", cascade={"persist"})
     */
   private $site;

///////////////// ***********************************       constructeur                ***************************//


    public function __construct()
    {
        $this->site = new ArrayCollection();
    }

    ///////////////// ***********************************     GETTERS AND SETTERS         ***************************//

    /**
     * @return string
     */
    public function getDataareaid()
    {
        return $this->dataareaid;
    }

    /**
     * @param string $dataareaid
     */
    public function setDataareaid($dataareaid)
    {
        $this->dataareaid = $dataareaid;
    }


    /**
     * @return string
     */
    public function getNomclient()
    {
        return $this->nomclient;
    }

    /**
     * @param string $nomclient
     */
    public function setNomclient($nomclient)
    {
        $this->nomclient = $nomclient;
    }

    /**
     * @return int
     */
    public function getCodeclient()
    {
        return $this->codeclient;
    }

    /**
     * @param int $codeclient
     */
    public function setCodeclient($codeclient)
    {
        $this->codeclient = $codeclient;
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
    public function getAdresse01()
    {
        return $this->adresse01;
    }

    /**
     * @param string $adresse01
     */
    public function setAdresse01($adresse01)
    {
        $this->adresse01 = $adresse01;
    }

    /**
     * @return int
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * @param int $codepostal
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;
    }

    /**
     * @return string
     */
    public function getVillelocalite()
    {
        return $this->villelocalite;
    }

    /**
     * @param string $villelocalite
     */
    public function setVillelocalite($villelocalite)
    {
        $this->villelocalite = $villelocalite;
    }

    /**
     * @return string
     */
    public function getNumtel1()
    {
        return $this->numtel1;
    }

    /**
     * @param string $numtel1
     */
    public function setNumtel1($numtel1)
    {
        $this->numtel1 = $numtel1;
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Site
     */
    public function getSite()
    {
        return $this->site;
    }
    /**
     * Add site
     * @param Site $site
     *
     */
    public function addSite(Site $site)
    {
        if (!$site->getId() == null) {
            $site->setClient($this);
            $this->site[] = $site;
        }
    }

    /**
     * @param Site $site
     */
    public function removeSite(Site $site)
    {
        $this->site->removeElement($site);
    }








}

