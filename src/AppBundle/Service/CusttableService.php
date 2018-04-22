<?php

namespace AppBundle\Service;


use AnalyticsBundle\Entity\ClientAx;
use AppBundle\Entity\Client;
use AppBundle\Entity\Fiche;
use AppBundle\Entity\Site;

class CusttableService {


	/**
	 * @param $code
	 *
	 * @return string
	 */

	public function formaterpipes( $code ) {
		$coderacco = ltrim( $code, '0' ); //supprime les zéros DEVANT la chaine de caracteres
		$coderacco = '|' . $coderacco . '|';

		return $coderacco;
	}

	/**
	 * @param Fiche $fiche
	 *
	 * @return mixed
	 */
	public function completerclient(Fiche $fiche, ClientAx $siteoriginel, ClientAx $clientoriginel ) {

		$sitedelafiche = new Site();
		$sitedelafiche->setNomSite($siteoriginel->getNom());
		$sitedelafiche->setCodePostalSite($siteoriginel->getCodepostal());
		$sitedelafiche->setCodeSite($siteoriginel->getAccountNum());
		$sitedelafiche->setAdresseSite01($siteoriginel->getAdresse());
		$sitedelafiche->setVilleSite($siteoriginel->getVille());

		$clientdelafiche = new Client();
		$clientdelafiche->setDataareaid($clientoriginel->getDataareaid());
		$clientdelafiche->setNomclient($clientoriginel->getNom());
		$clientdelafiche->setCodeclient($clientoriginel->getAccountNum());
		$clientdelafiche->setType($clientoriginel->getPricegroup());
		$clientdelafiche->setAdresse01($clientoriginel->getAdresse());
		$clientdelafiche->setCodepostal($clientoriginel->getCodepostal());
		$clientdelafiche->setVillelocalite($clientoriginel->getVille());
		$clientdelafiche->setNumtel1($clientoriginel->getPhone());
		$clientdelafiche->setNumtel2($clientoriginel->getCellularphone());

		$sitedelafiche->setClient($clientdelafiche);
		$fiche->setSite($sitedelafiche);
		$fichecompletee = $fiche;

		return array($fichecompletee, $clientdelafiche, $sitedelafiche);
	}

}