<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Secteur;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class SecteurRepository extends EntityRepository {
	public function getZonebyficheandNum( $numero, $fiche ) {
		$qb = $this->createQueryBuilder( 'z' )
		           ->where( 'z.numero = :numero' )
		           ->setParameter( 'numero', $numero )
		           ->andWhere( 'z.fiche = :fiche' )
		           ->setParameter( 'fiche', $fiche );

		return $qb
			->getQuery()
			->getOneOrNullResult();
	}
}