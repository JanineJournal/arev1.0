<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * InterTP
 *
 * @ORM\Table(name="inter_tp")
 * @ORM\Entity
 */
class InterTP
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="commentaire", type="text", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @var string
 * @Assert\Length(
     *      min = 2,
     *      max =80)
     * @ORM\Column(name="operateurTP", type="string", length=80, nullable=true)
     */
    private $operateurtp;

    /**
     * @var bool
     *
     * @ORM\Column(name="facturable", type="boolean", nullable=true)
     */
    private $facturable;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTP", type="datetime")
     */
    private $dateTP;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fiche", inversedBy="interTP", cascade={"persist"})
     *
     */
    private $fiche;

    ///////////////// ***********************************       constructeur                ***************************//

    public function __construct()
    {
        $this->setDateTP(new \Datetime());

    }

    /********************************************    FONCTIONS ******************************************/

    public function __toString()
    {
        $tpsav = "Intervention : " . $this->commentaire.'.';
        return $tpsav;
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
     * @param string $commentaire
     *
     * @return $this
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set facturable
     *
     * @param boolean $facturable
     * @return $this
     */
    public function setFacturable($facturable)
    {
        $this->facturable = $facturable;

        return $this;
    }

    /**
     * Get facturable
     * @return bool
     */
    public function getFacturable()
    {
        return $this->facturable;
    }

    /**
     * Set dateTP
     * @param \DateTime $dateTP
     *
     * @return $this
     */
    public function setDateTP($dateTP)
    {
        $this->dateTP = $dateTP;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTP()
    {
        return $this->dateTP;
    }


    /**
     * @return Fiche
     */
    public function getFiche()
    {
        return $this->fiche;
    }

    /**
     * @param  $fiche
     */
    public function setFiche($fiche)
    {
        $this->fiche = $fiche;
    }

    /**
     * @return string
     */
    public function getOperateurtp()
    {
        return $this->operateurtp;
    }

    /**
     * @param  $operateurtp
     */
    public function setOperateurtp($operateurtp)
    {
        $this->operateurtp = $operateurtp;
    }

}

