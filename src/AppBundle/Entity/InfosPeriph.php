<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfosPeriph
 *
 * @ORM\Table(name="infos_periph")
 * @ORM\Entity
 */
class InfosPeriph
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
     *
     * @ORM\Column(name="numSerie", type="string", length=20, nullable=true)
     */
    private $numSerie;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=4, nullable=true)
     */
    private $langue;

    /**
     * @var string
     *
     * @ORM\Column(name="options", type="string", length=10, nullable=true)
     */
    private $options;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=50, nullable=true)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="refElixir", type="string", length=50, nullable=true)
     */
    private $refElixir;

    /**
     * @var string
     *
     * @ORM\Column(name="prefixe", type="string", length=50, nullable=true)
     */
    private $prefixe;


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
     * Set numSerie
     *
     * @param string $numSerie
     *
     * @return InfosPeriph
     */
    public function setNumSerie($numSerie)
    {
        $this->numSerie = $numSerie;

        return $this;
    }

    /**
     * Get numSerie
     *
     * @return string
     */
    public function getNumSerie()
    {
        return $this->numSerie;
    }

    /**
     * Set langue
     *
     * @param string $langue
     *
     * @return InfosPeriph
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return string
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Set options
     *
     * @param string $options
     *
     * @return InfosPeriph
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return InfosPeriph
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set refElixir
     *
     * @param string $refElixir
     *
     * @return InfosPeriph
     */
    public function setRefElixir($refElixir)
    {
        $this->refElixir = $refElixir;

        return $this;
    }

    /**
     * Get refElixir
     *
     * @return string
     */
    public function getRefElixir()
    {
        return $this->refElixir;
    }

    /**
     * Set prefixe
     *
     * @param string $prefixe
     *
     * @return InfosPeriph
     */
    public function setPrefixe($prefixe)
    {
        $this->prefixe = $prefixe;

        return $this;
    }

    /**
     * Get prefixe
     *
     * @return string
     */
    public function getPrefixe()
    {
        return $this->prefixe;
    }
}

