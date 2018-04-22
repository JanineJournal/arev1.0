<?php

namespace AnalyticsBundle\Repository;


use Doctrine\ORM\EntityRepository;


class SvcCallTableRepository extends EntityRepository
{
    // trouve les numéros de commande ordonnés pour un site
    public function myfindCdes($codesite)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT DISTINCT c.salesid
      FROM   AnalyticsBundle:SvcCallTable a
       JOIN AnalyticsBundle:TaskTable b
         WITH a.dataareaid = b.dataareaid
            AND a.svccallid = b.svccallid
       JOIN AnalyticsBundle:SalesTable c
         WITH c.dataareaid = b.dataareaid
            AND c.salesid = b.salesid
       JOIN AnalyticsBundle:Salesline d
         WITH c.dataareaid = d.dataareaid
            AND d.salesid = c.salesid
      WHERE  a.dataareaid = :ctca
       AND a.custaccount = :codesite
       AND a.calltypeId = :INST
      ORDER  BY c.salesid DESC  '
        );

        $query->setParameters(array(
            'ctca' => 'ctca',
            'INST' => 'INST',
            'codesite' => $codesite
        ));

        return $query->getResult();
// to get just one result: $unseulclient = $query->setMaxResults(1)->getOneOrNullResult();
    }

// retourne les données liées au matériel de la commande sélectionnée
    public function myfindLignesCde($codesite, $salesid)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT d.name, d.qtyordered, d.itemid, d.spllocation
      FROM   AnalyticsBundle:SvcCallTable a
       JOIN AnalyticsBundle:TaskTable b
         WITH a.dataareaid = b.dataareaid
            AND a.svccallid = b.svccallid
       JOIN AnalyticsBundle:SalesTable c
         WITH c.dataareaid = b.dataareaid
            AND c.salesid = b.salesid
       JOIN AnalyticsBundle:Salesline d
         WITH c.dataareaid = d.dataareaid
            AND d.salesid = c.salesid
      WHERE  a.dataareaid = :ctca
       AND a.custaccount = :codesite
              AND d.salesid = :salesid
       AND a.calltypeId = :INST'
        );

        $query->setParameters(array(
            'ctca' => 'ctca',
            'INST' => 'INST',
            'salesid' => $salesid,
            'codesite' => $codesite
        ));

        return $query->getResult();
// to get just one result: $unseulclient = $query->setMaxResults(1)->getOneOrNullResult();
    }
}
