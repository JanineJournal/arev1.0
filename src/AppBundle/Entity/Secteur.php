<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Secteur
 *
 * @ORM\Table(name="secteur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SecteurRepository")
 */
class Secteur
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
     *      min = 1,
     *      max = 20)
     * @ORM\Column(name="nom", type="string", length=20, nullable=true)
     */
    private $nom;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 20)
     * @ORM\Column(name="sp1", type="string", length=50, nullable=true)
     */
    private $sp1;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 20)
     * @ORM\Column(name="sp2", type="string", length=50, nullable=true)
     */
    private $sp2;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 6)
     * @ORM\Column(name="entree", type="string", nullable=true)
     */
    private $entree;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 6)
     * @ORM\Column(name="sortie", type="string", nullable=true)
     */
    private $sortie;

    /**
     * @var integer
     * @Assert\Length(
     *      min = 1,
     *      max = 6)
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tempo", type="boolean", nullable=true)
     */
    private $tempo;

    /**
     * @var \AppBundle\Entity\Fiche
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fiche", inversedBy="secteur")
     */
    private $fiche;

    /**
     * @OneToMany(targetEntity="Peripherique", mappedBy="secteur", cascade="all", orphanRemoval=true)
     */
    private $peripherique;


    ///////////////// ***********************************       CONSTRUCTEURS              ***************************//


    /**
     * Secteur constructor.
     */
    public function __construct()
    {

    }

    ///////////////// ***********************************       GET AND SETTERS              ***************************//


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getSp1()
    {
        return $this->sp1;
    }

    /**
     * @param string $sp1
     */
    public function setSp1($sp1)
    {
        $this->sp1 = $sp1;
    }

    /**
     * @return string
     */
    public function getSp2()
    {
        return $this->sp2;
    }

    /**
     * @param string $sp2
     */
    public function setSp2($sp2)
    {
        $this->sp2 = $sp2;
    }

    /**
     * @return string
     */
    public function getTempo()
    {
        return $this->tempo;
    }

    /**
     * @param string $tempo
     */
    public function setTempo($tempo)
    {
        $this->tempo = $tempo;
    }

    /**
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return string
     */
    public function getEntree()
    {
        return $this->entree;
    }

    /**
     * @param string $entree
     */
    public function setEntree($entree)
    {
        $this->entree = $entree;
    }

    /**
     * @return string
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * @param string $sortie
     */
    public function setSortie($sortie)
    {
        $this->sortie = $sortie;
    }



  ////// ****************************************************************************/

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
     * Add peripherique
     * @param Peripherique $peripherique
     *
     */
    public function addPeripherique(Peripherique $peripherique)
    {
        if (!$peripherique->getNumIni() == null) {
            $peripherique->setSecteur($this);
            $this->peripherique[] = $peripherique;
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getPeripherique()
    {
        return $this->peripherique;
    }

    /**
     * @param Peripherique $peripherique
     */
    public function removePeripherique(Peripherique $peripherique)
    {
        $this->peripherique->removeElement($peripherique);
    }




}

