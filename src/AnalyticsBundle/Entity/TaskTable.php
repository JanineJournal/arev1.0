<?php

namespace AnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskTable
 *
 * @ORM\Table(name="MSM_TASKTABLE")
 * @ORM\Entity
 */
class TaskTable
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
     * @ORM\Column(name="salesid", type="string", length=20, nullable=true)
     */
    private $salesid;


	///////////////////////////**************    GETTERS AND SETTERS         *******************************************///



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



}