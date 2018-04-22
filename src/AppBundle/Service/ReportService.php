<?php

namespace AppBundle\Service;

use AppBundle\Repository\FicheRepository;
use DateTime;

class ReportService {


	/**
	 * @param FicheRepository $fiches
	 *
	 * @return array
	 */
	public function report(FicheRepository $fiches) {

		$arrayNombrAn = array(); // tableau pour le nombre de fiches par an et par mois

		for ( $y = 2017; $y < 2022; $y ++ ) {
			$nbFichesAnnee = 0; // Initialisation du nombre de fiches total pour l'année sur  laquelle on boucle

			for ( $x = 01; $x < 13; $x ++ ) { // boucle sur 12 mois pour l'année
				$nbParMois     = count( $fiches->myfindByMois( $x, $y ) );
				$arrayInterM[] = array( 'mois' => $x, 'an' => $y, 'compteur' => $nbParMois );
				$nbFichesAnnee = $nbFichesAnnee + $nbParMois;
			}
			$arrayNombrAn[] = array( 'an' => $y, 'nombre' => $nbFichesAnnee );
		}

		$encours   = $fiches->findAllInterventionsEnCoursParDate();
		$nbencours = count( $encours ); // compte le nombre de fiches dont le statut est en cours pour la journée

		$favalider  = $fiches->findAllInterventionsAvaliderParDate();
		$nbavalider = count( $favalider );

		$interventionsFacturees = array();

// periode de 90 jours précédents, interventions diverses
		$auj = new DateTime();
		$auj->setTime( 0, 0, 0 );
		$periodedata = 90;

		for ( $x = 0; $x < $periodedata; $x ++ ) { // boucle sur 90 jours à partir d'aujourd'hui
			$end = clone $auj;
			$end->modify( '-1day' ); // entre auj et end il y a une journée

			$LM                = count( $fiches->myfindBySiteInterStatutJour( "72", "installation", "OK facturation", $auj, $end ) );
			$LR                = count( $fiches->myfindBySiteInterStatutJour( "85", "installation", "OK facturation", $auj, $end ) );
			$CL                = count( $fiches->myfindBySiteInterStatutJour( "63", "installation", "OK facturation", $auj, $end ) );
			$installationsJour = $LM + $LR + $CL;

			$LMC = count( $fiches->myfindBySiteInterStatutJour( "72", "complement", "OK facturation", $auj, $end ) );;
			$LRC = count( $fiches->myfindBySiteInterStatutJour( "85", "complement", "OK facturation", $auj, $end ) );;
			$CLC = count( $fiches->myfindBySiteInterStatutJour( "63", "complement", "OK facturation", $auj, $end ) );;
			$complementsJour = $LMC + $LRC + $CLC;

			$LMRM = count( $fiches->myfindBySiteInterStatutJour( "72", "remontage/Demontage", "OK facturation", $auj, $end ) );;
			$LRRM = count( $fiches->myfindBySiteInterStatutJour( "85", "remontage/Demontage", "OK facturation", $auj, $end ) );;
			$CLRM = count( $fiches->myfindBySiteInterStatutJour( "63", "remontage/Demontage", "OK facturation", $auj, $end ) );;
			$remontagesJour = $LMRM + $LRRM + $CLRM;

			$LMS = count( $fiches->myfindBySiteInterStatutJour( "72", "SAV", "OK facturation", $auj, $end ) );;
			$LRS = count( $fiches->myfindBySiteInterStatutJour( "85", "SAV", "OK facturation", $auj, $end ) );;
			$CLS = count( $fiches->myfindBySiteInterStatutJour( "63", "SAV", "OK facturation", $auj, $end ) );;
			$savJour = $LMS + $LRS + $CLS;

			$LMRN = count( $fiches->myfindBySiteInterStatutJour( "72", "renouvellement", "OK facturation", $auj, $end ) );;
			$LRRN = count( $fiches->myfindBySiteInterStatutJour( "85", "renouvellement", "OK facturation", $auj, $end ) );;
			$CLRN = count( $fiches->myfindBySiteInterStatutJour( "63", "renouvellement", "OK facturation", $auj, $end ) );;
			$renouvellementsJour = $LMRN + $LRRN + $CLRN;

			$tabcompteurs = array(
				'installationsJour'   => $installationsJour,
				'LM'                  => $LM,
				'LR'                  => $LR,
				'CL'                  => $CL,
				'complementsJour'     => $complementsJour,
				'remontagesJour'      => $remontagesJour,
				'renouvellementsJour' => $renouvellementsJour,
				'savJour'             => $savJour,
				'LMRM'                => $LMRM,
				'LRRM'                => $LRRM,
				'CLRM'                => $CLRM,
				'LMC'                 => $LMC,
				'LRC'                 => $LRC,
				'CLC'                 => $CLC,
				'LMS'                 => $LMS,
				'LRS'                 => $LRS,
				'CLS'                 => $CLS,
				'LMRN'                => $LMRN,
				'LRRN'                => $LRRN,
				'CLRN'                => $CLRN,
				'interventionsJour'   => $installationsJour + $complementsJour + $remontagesJour + $renouvellementsJour + $savJour,
			);

			$interventionsFacturees[] = array( 'jour' => $end, 'compteur' => $tabcompteurs );

			$auj = clone $end;
		} //periode data is over

		return  array(
			'periodedata' => 90,
			// nombre de jour depuis celui à partir duquel est ouverte la page (pour ne pas faire requête trop lourde; 3 mois)

			'cumulAn'           => $arrayNombrAn,
			// pour le tableau de synthese
			'interventionsMois' => $arrayInterM,
			// tableau reprenant fiches totales dénombrées dans l'onglet 4 par jour

			'nbencours' => $nbencours,
			// nombre de fiches restants en cours (à clôturer donc..)
			'encours'   => $encours,
			// toutes les fiches en cours qui se trouvent dans l'onglet 2

			'nbavalider' => $nbavalider,
			'favalider'  => $favalider,

			'interventionsFacturees' => $interventionsFacturees,
			// tableau reprenant toutes les fiches validées dénombrées et classées par jour
		);
	}
}