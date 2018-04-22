<?php

namespace AppBundle\Service;

use AppBundle\Entity\Fiche;
use AppBundle\Entity\Peripherique;
use AppBundle\Entity\Secteur;
use DateTime;

class BlankFiche {


	/**
	 * @param $code
	 *
	 * @return Fiche
	 */
	public function nouvelleFiche($code) {
		$fiche = new Fiche();
		$fiche->setCoderacco($code);
		$fiche->setDate(new Datetime());
		$fiche->setStatut('en cours');

		$secteurZero = new Secteur();
		$secteurZero->setNom( 'Zone initiale' );
		$fiche->addSecteur( $secteurZero );

		$disjoncteur = new Peripherique();
		$disjoncteur->setNom( "Disjoncteur" );
		$disjoncteur->setLocalisation( "Sur prise avec doubleur" );

		$hp = new Peripherique();
		$hp->setNom( "Haut-Parleur" );
		$hp->setLocalisation( "Dans l'entrée" );

		$clavier = new Peripherique();
		$clavier->setNom( "Clavier" );
		$clavier->setLocalisation( "Dans l'entrée" );
		$secteurZero->addPeripherique( $clavier );
		$secteurZero->addPeripherique( $hp );
		$secteurZero->addPeripherique( $disjoncteur );

		return $fiche;
	}

	public function bondecommande( $codesite, $em2 ) {
		$listecdes = array();
		$cdes      = $em2->getRepository( SvcCallTable::class )->myfindCdes( $codesite );
		foreach ( $cdes as $cde ) {
			$listecdes[] = $cde['salesid'];
		}
			return $listecdes;
	}






	public
	function Duplicata(Fiche $id)
	{
		//  $em2 = $this->getDoctrine()->getManager('analytics');
		$em1 = $this->getDoctrine()->getManager('visiteur');

		$ficheacloner = $em1->getRepository(Fiche::class)->find($id);

		$ficheclonee = clone $ficheacloner;

		$radioacloner = $ficheacloner->getRadio(); //ICI LES ONE TO ONE CAR DUPLIQUER ID IMPOSSIBLE
		$filaireacloner = $ficheacloner->getFilaire();

		if ($radioacloner) {
			$nouvelleRadio = clone $radioacloner;
			$ficheclonee->setRadio($nouvelleRadio);
			$em1->persist($nouvelleRadio);
		}

		if ($filaireacloner) {
			$newFilaire = clone $filaireacloner;
			$ficheclonee->setFilaire($newFilaire);
			$em1->persist($newFilaire);
		}

		$operateurTP = $this->getUser()->getUsername();
		$ficheclonee->setOperateurTP($operateurTP);
		$ficheclonee->setDate(new Datetime());
		$ficheclonee->setStatut('en cours');

		$em1->persist($ficheclonee);
		$em1->flush();

		return $ficheclonee;
	}

}