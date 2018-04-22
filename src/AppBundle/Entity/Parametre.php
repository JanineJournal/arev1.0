<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Parametre
 *
 * @ORM\Table(name="parametre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParametreRepository")
 */
class Parametre
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
     * @ORM\Column(name="categorie", type="string", length=20, nullable=true)
     */
    private $categorie;

    /**
     * @var string
     * @Assert\Length(
     *      min = 1,
     *      max =80)
     * @ORM\Column(name="valeur_libelle", type="string", length=80, nullable=true)
     */
    private $valeur_libelle;


    ///////////////// ***********************************       CONSTRUCTEUR                       ***************************//


    public function __toString()
    {
       return $this->valeur_libelle;
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
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return string
     */
    public function getValeurLibelle()
    {
        return $this->valeur_libelle;
    }

    /**
     * @param string $valeur_libelle
     */
    public function setValeurLibelle($valeur_libelle)
    {
        $this->valeur_libelle = $valeur_libelle;
    }


}

