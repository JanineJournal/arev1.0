<?php

namespace AppBundle\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;

class FicheRepository extends EntityRepository
{
    public function findAllInterventionsEnCoursParDate()
    {
        return $this->createQueryBuilder('fiche')
            ->where('fiche.statut = :statut')
            ->setParameter('statut', "en cours")
            ->orderBy('fiche.date', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllInterventionsAvaliderParDate()
    {
        return $this->createQueryBuilder('fiche')
            ->where('fiche.statut = :statut')
            ->setParameter('statut', "terminé")
            ->orderBy('fiche.date', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function myfindmesfiches($username)
    {
        return $this->createQueryBuilder('fiche')
            ->where('fiche.operateurtp = :username')
            ->andWhere('fiche.statut =:statut')
            ->setParameter('statut', "en cours")
            ->setParameter('username', $username)
            ->orderBy('fiche.date', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function myfindBySiteInterStatutJour( $site,  $inter,   $statut, DateTime $d, DateTime $e)
    {
        return $this->createQueryBuilder('f')
            ->where('f.intervention = :intervention')
            ->andWhere('f.centretsv =:site')
            ->andWhere('f.statut =:statut')
            ->andWhere('f.date <:date')
            ->andWhere('f.date >:end')
            ->setParameter('statut', $statut)
            ->setParameter('site', $site)
            ->setParameter('intervention', $inter)
            ->setParameter('date', $d)
            ->setParameter('end', $e)
            ->getQuery()
            ->execute();
    }

    public function myfindBytoutespourJour( $inter, DateTime $d, DateTime $e)
    {
        return $this->createQueryBuilder('f')
            ->where('f.intervention = :intervention')
            ->andWhere('f.date <:date')
            ->andWhere('f.date >:end')
            ->setParameter('intervention', $inter)
            ->setParameter('date', $d)
            ->setParameter('end', $e)
            ->getQuery()
            ->execute();
    }

    public function myfindByMois($mois, $an)
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
        return $this->createQueryBuilder('f')
            ->where('YEAR(f.date) = :an')
            ->andWhere('MONTH(f.date) = :mois')
            ->setParameter('mois', $mois)
            ->setParameter('an', $an)
            ->getQuery()
            ->execute();
    }

    public function myfindByClient($codeclient)
    {
        return $this->createQueryBuilder('f')
            ->where('f.site.client.codeclient = :client')
            ->setParameter('client', $codeclient)
            ->getQuery()
            ->execute();
    }
}
