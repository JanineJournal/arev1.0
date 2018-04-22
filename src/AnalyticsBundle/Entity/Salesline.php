<?php

namespace AnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salesline
 *
 * @ORM\Table(name="SALESLINE")
 * @ORM\Entity
 */
class Salesline
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

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(name="qtyordered", type="integer", length=50, nullable=true)
     */
    private $qtyordered;

    /**
     * @var string
     * @ORM\Column(name="itemid", type="string", length=50, nullable=true)
     */
    private $itemid;

    /**
     * @var string
     * @ORM\Column(name="spllocation", type="string", length=20, nullable=true)
     */
    private $spllocation;


    ///////////////////////////**************    GETTERS AND SETTERS         *******************************************///


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

    /**
     * @return string
     */
    public function getSpllocation()
    {
        return $this->spllocation;
    }

    /**
     * @param string $spllocation
     */
    public function setSpllocation($spllocation)
    {
        $this->spllocation = $spllocation;
    }

    /**
     * @return int
     */
    public function getItemid()
    {
        return $this->itemid;
    }

    /**
     * @param int $itemid
     */
    public function setItemid($itemid)
    {
        $this->itemid = $itemid;
    }

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

    /**
     * @return int
     */
    public function getQtyordered()
    {
        return $this->qtyordered;
    }

    /**
     * @param int $qtyordered
     */
    public function setQtyordered($qtyordered)
    {
        $this->qtyordered = $qtyordered;
    }




}