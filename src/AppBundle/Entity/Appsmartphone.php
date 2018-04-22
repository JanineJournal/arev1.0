<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Appsmartphone
 *
 * @ORM\Table(name="appsmartphone")
 * @ORM\Entity
 */
class Appsmartphone
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
     * @ORM\Column(name="typeApplication", type="string", length=20, nullable=true)
     */
    private $typeapplication;

    /**
     * @var integer
     * @Assert\Length(
     *      min = 1,
     *      max = 20)
     * @ORM\Column(name="codePin", type="integer", length=20, nullable=true)
     */
    private $codepin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="streaming", type="boolean", nullable=true)
     */
    private $streaming;

    /**
     * @ORM\OneToOne(targetEntity="Fiche", inversedBy="appsmartphone", cascade={"persist"})
     */
    private $fiche;

    /**
     * @OneToMany(targetEntity="Comptevideo", mappedBy="appsmartphone", cascade="all", orphanRemoval=true)
     */
    private $comptevideo;


    ///////////////// ***********************************       constructeur                ***************************//

    public function __construct()
    {
          $this->comptevideo = new ArrayCollection();
    }

    ///////////////////////////            GETTER SETTER            ///////////////////////////

    /**
     * @return string
     */
    public function getTypeapplication()
    {
        return $this->typeapplication;
    }

    /**
     * @param string $typeapplication
     */
    public function setTypeapplication($typeapplication)
    {
        $this->typeapplication = $typeapplication;
    }

    /**
     * @return int
     */
    public function getCodepin()
    {
        return $this->codepin;
    }

    /**
     * @param int $codepin
     */
    public function setCodepin($codepin)
    {
        $this->codepin = $codepin;
    }

    /**
     * @return bool
     */
    public function isStreaming()
    {
        return $this->streaming;
    }

    /**
     * @param bool $streaming
     */
    public function setStreaming($streaming)
    {
        $this->streaming = $streaming;
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

    /**
     * @return mixed
     */
    public function getComptevideo()
    {
        return $this->comptevideo;
    }

    /**
     * @param mixed $comptevideo
     */
    public function setComptevideo($comptevideo)
    {
        $this->comptevideo = $comptevideo;
    }

    /**
     * Add Comptevideo
     *
     * @param Comptevideo $comptevideo
     * @return Appsmartphone
     */
    public function addComptevideo(Comptevideo $comptevideo)
    {
        if (!$comptevideo->getIdentifiant() == null) {
            $this->comptevideo[] = $comptevideo;
            $comptevideo->setAppsmartphone($this);
        }
        return $this;
    }

    /**
     * @param  Comptevideo $comptevideo
     */
    public function removeComptevideo( Comptevideo $comptevideo)
    {
        $this->comptevideo->removeElement($comptevideo);
    }
}

