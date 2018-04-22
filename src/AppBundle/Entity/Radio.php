<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Radio
 *
 * @ORM\Table(name="radio")
 * @ORM\Entity
 */
class Radio {
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
	 * @Assert\Length(
	 *      min = 2,
	 *      max =30)
	 * @ORM\Column(name="numTelSim", type="integer", nullable=true)
	 */
	private $numTelsim;

	/**
	 * @var integer
	 * @Assert\Length(
	 *      min = 2,
	 *      max =80)
	 * @ORM\Column(name="numSerieSim", type="integer", nullable=true)
	 */
	private $numSeriesim;

	/**
	 * @var string
	 * @Assert\Length(
	 *      min = 2,
	 *      max =30)
	 * @ORM\Column(name="operateur_sim", type="string", length=30, nullable=true)
	 */
	private $operateurSim;

	/**
	 * @var \AppBundle\Entity\Fiche
	 *
	 * @ORM\OneToOne(targetEntity="Fiche", mappedBy="radio", cascade={"persist"})
	 */
	private $fiche;

	/**
	 * @var string
	 * @Assert\Length(
	 *      min = 2,
	 *      max =30)
	 * @ORM\Column(name="emplacement_clavier", type="string", length=30, nullable=true)
	 */
	private $emplacementClavier;

	/**
	 * @var string
	 * @Assert\Length(
	 *      min = 2,
	 *      max =30)
	 * @ORM\Column(name="emplacementdisj", type="string", length=30, nullable=true)
	 */
	private $emplacementdisj;

	/**
	 * @var string
	 * @Assert\Length(
	 *      min = 2,
	 *      max =30)
	 * @ORM\Column(name="emplacement_hp", type="string", length=30, nullable=true)
	 */
	private $emplacementHP;


	///////////////// ***********************************       GETTERS AND SETTERS                ***************************//


	/**
	 * @return string
	 */
	public function getOperateurSim() {
		return $this->operateurSim;
	}

	/**
	 * @param string $operateurSim
	 */
	public function setOperateurSim( $operateurSim ) {
		$this->operateurSim = $operateurSim;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return Fiche
	 */
	public function getFiche() {
		return $this->fiche;
	}

	/**
	 * @param Fiche $fiche
	 */
	public function setFiche( $fiche ) {
		$this->fiche = $fiche;
	}

	/**
	 * @return int
	 */
	public function getNumTelsim() {
		return $this->numTelsim;
	}

	/**
	 * @param int $numTelsim
	 */
	public function setNumTelsim( $numTelsim ) {
		$this->numTelsim = $numTelsim;
	}

	/**
	 * @return int
	 */
	public function getNumSeriesim() {
		return $this->numSeriesim;
	}

	/**
	 * @param int $numSeriesim
	 */
	public function setNumSeriesim( $numSeriesim ) {
		$this->numSeriesim = $numSeriesim;
	}

	public function getEmplacementClavier() {
		return $this->emplacementClavier;
	}


	public function setEmplacementClavier(  $emplacementClavier ) {
		$this->emplacementClavier = $emplacementClavier;
	}

	public function getEmplacementdisj() {
		return $this->emplacementdisj;
	}

	public function setEmplacementdisj( string $emplacementdisj ) {
		$this->emplacementdisj = $emplacementdisj;
	}

	public function getEmplacementHP() {
		return $this->emplacementHP;
	}

	public function setEmplacementHP( $emplacementHP ) {
		$this->emplacementHP = $emplacementHP;
	}


}

