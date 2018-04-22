<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Site
 *
 * @ORM\Table(name="site")
 * @ORM\Entity
 */
class Site
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
     * @Assert\Length(
     *      min = 1,
     *      max = 20)
     * @ORM\Column(name="codeSite", type="string", length=20, nullable=true)
     */
    private $codeSite;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 50)
     * @ORM\Column(name="nomSite", type="string", length=50, nullable=true)
     */
    private $nomSite;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max =150)
     * @ORM\Column(name="adresseSite", type="string", length=150, nullable=true))
     */
    private $adresseSite01;

    /**
     * @var string
     * @Assert\Length(
     *      min = 5,
     *      max =7)
     * @ORM\Column(name="codePostalSite", type="string", nullable=true)
     */
    private $codePostalSite;

    /**
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max =50)
     * @ORM\Column(name="villeSite", type="string", length=50, nullable=true)
     */
    private $villeSite;

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
     * @Assert\Length(
     *      min = 10,
     *      max =20)
     * @ORM\Column(name="numTel3", type="string", length=20, nullable=true)
     */
    private $numtel3;

    /**
     * @var string
     * @Assert\Length(
     *      min = 10,
     *      max =20)
     * @ORM\Column(name="numTel4", type="string", length=20, nullable=true)
     */
    private $numtel4;

    /**
     * @var string
     *
     * @ORM\Column(name="dataareaid", type="string", length=4, nullable=true)
     */
    private $dataareaid;



    /************************** Many to One **********/

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="site", cascade={"persist"})
     */
    private $client;

    /************************** ONE TO MANY **********/

    /**
     * @ORM\OneToMany(targetEntity="Fiche", mappedBy="site", cascade={"persist"})
     */
    private $fiche;


    ///////////////// ***********************************       constructeur                ***************************//


    public function __construct()
    {
        $this->fiche = new ArrayCollection();
    }


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
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
        $client->addSite($this);
    }

    /**
     * Set codeSite
     *
     * @param string $codeSite
     *
     * @return Site
     */
    public function setCodeSite($codeSite)
    {
        $this->codeSite = $codeSite;

        return $this;
    }

    /**
     * Get codeSite
     *
     * @return string
     */
    public function getCodeSite()
    {
        return $this->codeSite;
    }

    /**
     * Set nomSite
     *
     * @param string $nomSite
     *
     * @return Site
     */
    public function setNomSite($nomSite)
    {
        $this->nomSite = $nomSite;

        return $this;
    }

    /**
     * Get nomSite
     *
     * @return string
     */
    public function getNomSite()
    {
        return $this->nomSite;
    }

    /**
     * Set adresseSite01
     *
     * @param string $adresseSite01
     *
     * @return Site
     */
    public function setAdresseSite01($adresseSite01)
    {
        $this->adresseSite01 = $adresseSite01;

        return $this;
    }

    /**
     * Get adresseSite01
     *
     * @return string
     */
    public function getAdresseSite01()
    {
        return $this->adresseSite01;
    }


    /**
     * Set codePostalSite
     *
     * @param integer $codePostalSite
     *
     * @return Site
     */
    public function setCodePostalSite($codePostalSite)
    {
        $this->codePostalSite = $codePostalSite;

        return $this;
    }

    /**
     * Get codePostalSite
     *
     * @return int
     */
    public function getCodePostalSite()
    {
        return $this->codePostalSite;
    }

    /**
     * Set villeSite
     *
     * @param string $villeSite
     *
     * @return Site
     */
    public function setVilleSite($villeSite)
    {
        $this->villeSite = $villeSite;

        return $this;
    }

    /**
     * Get villeSite
     *
     * @return string
     */
    public function getVilleSite()
    {
        return $this->villeSite;
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
     * @return mixed
     */
    public function getFiche()
    {
        return $this->fiche;
    }

    public function addFiche(Fiche $fiche)
    {
        if (!$fiche->getId() == null) {
            $this->fiche[] = $fiche;
            $fiche->setSite($this);
        }
        return $this;
    }

    public function removeFiche( Fiche $fiche)
    {
        $this->fiche->removeElement($fiche);
    }

}

