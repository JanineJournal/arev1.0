<?php

namespace AnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salestable
 *
 * @ORM\Table(name="SALESTABLE")
 * @ORM\Entity
 */
class SalesTable
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="dataareaid", type="string", length=4, unique=true)
     */
    private $dataareaid;

    /**
     * @var string
     * @ORM\Column(name="salesid", type="string", length=20, nullable=true)
     */
    private $salesid;



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
    public function getSalesid()
    {
        return $this->salesid;
    }

    /**
     * @param string $salesid
     */
    public function setSalesid($salesid)
    {
        $this->salesid = $salesid;
    }


}