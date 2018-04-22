<?php

namespace AnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dirpartytable
 *
 * @ORM\Table(name="DIRPARTYTABLE")
 * @ORM\Entity(repositoryClass="AnalyticsBundle\Repository\DirpartyTableRepository")
 */
class DirpartyTable
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="dataareaid", type="string", length=4, unique=true)
     */
    private $dataareaid;

    /**
     * @var string
     * @ORM\Column(name="partyid", type="string", length=20, nullable=true)
     */
    private $partyid;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=60, nullable=true)
     */
    private $name;




    public function __toString()
    {
       return $this->name;
    }



	///////////////////////////**************    GETTERS AND SETTERS         *******************************************///

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
    public function getPartyid()
    {
        return $this->partyid;
    }

    /**
     * @param string $partyid
     */
    public function setPartyid($partyid)
    {
        $this->partyid = $partyid;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }



}