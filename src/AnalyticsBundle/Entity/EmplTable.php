<?php

namespace AnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmplTable
 *
 * @ORM\Table(name="EMPLTABLE")
 * @ORM\Entity
 */
class EmplTable
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
     * @ORM\Column(name="calendarid", type="string", length=10, nullable=true)
     */
    private $calendarid;

    /**
     * @var string
     * @ORM\Column(name="emplidentnumber", type="string", length=30, nullable=true)
     */
    private $emplidentnumber;

    /**
     * @var string
     * @ORM\Column(name="ctc_typetech", type="string", length=10, nullable=true)
     */
    private $ctc_typetech;





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
    public function getCtcTypetech()
    {
        return $this->ctc_typetech;
    }

    /**
     * @param string $ctc_typetech
     */
    public function setCtcTypetech($ctc_typetech)
    {
        $this->ctc_typetech = $ctc_typetech;
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
    public function getCalendarid()
    {
        return $this->calendarid;
    }

    /**
     * @param string $calendarid
     */
    public function setCalendarid($calendarid)
    {
        $this->calendarid = $calendarid;
    }

    /**
     * @return string
     */
    public function getEmplidentnumber()
    {
        return $this->emplidentnumber;
    }

    /**
     * @param string $emplidentnumber
     */
    public function setEmplidentnumber($emplidentnumber)
    {
        $this->emplidentnumber = $emplidentnumber;
    }


}