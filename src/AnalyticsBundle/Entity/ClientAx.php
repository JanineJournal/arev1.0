<?php

namespace AnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientAx
 *
 * @ORM\Table(name="CUSTTABLE")
 * @ORM\Entity(repositoryClass="AnalyticsBundle\Repository\ClientAxRepository")
 */
class ClientAx
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="accountnum", type="string", length=20, unique=true)
     */
    private $accountnum;

    /**
     * @var boolean
     * @ORM\Column(name="splissite", type="boolean")
     */
    private $splissite;

    /**
     * @var string
     *
     * @ORM\Column(name="dataareaid", type="string", length=4)
     */
    private $dataareaid;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="cellularphone", type="string", length=20, nullable=true)
     */
    private $cellularphone;

    /**
     * @var string
     *
     * @ORM\Column(name="invoiceaccount", type="string", length=20, nullable=true)
     */
    private $invoiceaccount;

    /**
     * @var string
     *
     * @ORM\Column(name="pricegroup", type="string", length=10, nullable=true)
     */
    private $pricegroup;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=80, nullable=true)
     */
    private $emailClient;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=10, nullable=true)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=60, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=250, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="splsiteconnectioncodes", type="string", length=255, nullable=true)
     */
    private $totalcodesracco;

    /**
     * @var string
     *
     * @ORM\Column(name="splsiteconnectioncodeswithpipe", type="string", length=255, nullable=true)
     */
    private $totalcodesraccowithpipe;


    public function __toString()
    {
        $clientax = $this->getNom().' - Adr.: '.$this->getAdresse().' - '.$this->getCodepostal().' 
         '.$this->getVille().' / '.$this->getDataareaid().' - A.N.: '.$this->getAccountnum() ;
        return $clientax;
    }


   /********************************       GETTERS SETTERS       **********************************************************/

    /**
     * Set accountnum
     *
     * @param string $accountnum
     *
     * @return ClientAx
     */
    public function setAccountnum($accountnum)
    {
        $this->accountnum = $accountnum;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getAccountnum()
    {
        return $this->accountnum;
    }

    public function setDataareaid($dataareaid)
    {
        $this->dataareaid = $dataareaid;
        return $this;
    }

    public function getDataareaid()
    {
        return $this->dataareaid;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getCellularphone()
    {
        return $this->cellularphone;
    }

    /**
     * @param string $cellularphone
     */
    public function setCellularphone($cellularphone)
    {
        $this->cellularphone = $cellularphone;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getInvoiceaccount()
    {
        return $this->invoiceaccount;
    }

    /**
     * @param string $invoiceaccount
     */
    public function setInvoiceaccount($invoiceaccount)
    {
        $this->invoiceaccount = $invoiceaccount;
    }

    /**
     * @return string
     */
    public function getPricegroup()
    {
        return $this->pricegroup;
    }

    /**
     * @param string $pricegroup
     */
    public function setPricegroup($pricegroup)
    {
        $this->pricegroup = $pricegroup;
    }

    public function getEmailClient()
    {
        return $this->emailClient;
    }

    public function setEmailClient($emailClient)
    {
        $this->emailClient = $emailClient;
    }

    /**
     * @return string
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * @param string $codepostal
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getTotalcodesracco()
    {
        return $this->totalcodesracco;
    }

    /**
     * @param string $totalcodesracco
     */
    public function setTotalcodesracco($totalcodesracco)
    {
        $this->totalcodesracco = $totalcodesracco;
    }

    /**
     * @return string
     */
    public function getTotalcodesraccowithpipe()
    {
        return $this->totalcodesraccowithpipe;
    }

    /**
     * @param string $totalcodesraccowithpipe
     */
    public function setTotalcodesraccowithpipe($totalcodesraccowithpipe)
    {
        $this->totalcodesraccowithpipe = $totalcodesraccowithpipe;
    }

    public function getSplissite()
    {
        return $this->splissite;
    }

    public function setSplissite($splissite)
    {
        $this->splissite = $splissite;
    }


}

