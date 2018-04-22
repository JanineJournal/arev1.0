<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comptevideo
 *
 * @ORM\Table(name="comptevideo")
 * @ORM\Entity
 */
class Comptevideo
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
     *
     * @ORM\Column(name="identifiant", type="string", length=150, nullable=true)
     */
    private $identifiant;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 50)
     * @ORM\Column(name="localisation", type="string", length=50, nullable=true)
     */
    private $localisation;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 20)
     * @ORM\Column(name="codeCompte", type="string", length=20, nullable=true)
     */
    private $codecompte;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 155)
     * @ORM\Column(name="email_compte_video", type="string", length=155, nullable=true)
     */
    private $emailCompteVideo;

    /**
     * @var string
     *
     * @ORM\Column(name="questionCompteVideo", type="string", length=250, nullable=true)
     */
    private $questioncomptevideo;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max = 250)
     * @ORM\Column(name="reponseCompteVideo", type="string", length=250, nullable=true)
     */
    private $reponsecomptevideo;

    /**
     * @var \AppBundle\Entity\Appsmartphone
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Appsmartphone", inversedBy="comptevideo"))
     *
     */
    private $appsmartphone;

    ///////////////// ***********************************       GETTERS AND SETTERS                ***************************//


    ///////////////******************************************      GETTER SETTER        ***************************************/

    /**
     * @return string
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * @param string $identifiant
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;
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
     * @return string
     */
    public function getCodecompte()
    {
        return $this->codecompte;
    }

    /**
     * @param string $codecompte
     */
    public function setCodecompte($codecompte)
    {
        $this->codecompte = $codecompte;
    }

    /**
     * @return string
     */
    public function getEmailCompteVideo()
    {
        return $this->emailCompteVideo;
    }

    /**
     * @param string $emailCompteVideo
     */
    public function setEmailCompteVideo($emailCompteVideo)
    {
        $this->emailCompteVideo = $emailCompteVideo;
    }

    /**
     * @return string
     */
    public function getQuestioncomptevideo()
    {
        return $this->questioncomptevideo;
    }

    /**
     * @param string $questioncomptevideo
     */
    public function setQuestioncomptevideo($questioncomptevideo)
    {
        $this->questioncomptevideo = $questioncomptevideo;
    }

    /**
     * @return string
     */
    public function getReponsecomptevideo()
    {
        return $this->reponsecomptevideo;
    }

    /**
     * @param string $reponsecomptevideo
     */
    public function setReponsecomptevideo($reponsecomptevideo)
    {
        $this->reponsecomptevideo = $reponsecomptevideo;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Appsmartphone
     */
    public function getAppsmartphone()
    {
        return $this->appsmartphone;
    }

    /**
     * @param Appsmartphone $appsmartphone
     */
    public function setAppsmartphone($appsmartphone)
    {
        $this->appsmartphone = $appsmartphone;
    }


}

