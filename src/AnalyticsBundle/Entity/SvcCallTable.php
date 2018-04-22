<?php

namespace AnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SvcCallTable
 *
 * @ORM\Table(name="MSM_SVCCALLTABLE")
 * @ORM\Entity(repositoryClass="AnalyticsBundle\Repository\SvcCallTableRepository")
 */
class SvcCallTable
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="dataareaid", type="string", length=4, unique=true)
     */
    private $dataareaid;

    /**
     * @var string
     * @ORM\Column(name="svccallid", type="string", length=20, nullable=true)
     */
    private $svccallid;

    /**
     * @var string
     * @ORM\Column(name="custaccount", type="string", length=20, nullable=true)
     */
    private $custaccount;

    /**
     * @var string
     * @ORM\Column(name="calltypeid", type="string", length=20, nullable=true)
     */
    private $calltypeId;


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
    public function getSvccallid()
    {
        return $this->svccallid;
    }

    /**
     * @param string $svccallid
     */
    public function setSvccallid($svccallid)
    {
        $this->svccallid = $svccallid;
    }

    /**
     * @return string
     */
    public function getCustaccount()
    {
        return $this->custaccount;
    }

    /**
     * @param string $custaccount
     */
    public function setCustaccount($custaccount)
    {
        $this->custaccount = $custaccount;
    }

    /**
     * @return string
     */
    public function getCalltypeId()
    {
        return $this->calltypeId;
    }

    /**
     * @param string $calltypeId
     */
    public function setCalltypeId($calltypeId)
    {
        $this->calltypeId = $calltypeId;
    }




}