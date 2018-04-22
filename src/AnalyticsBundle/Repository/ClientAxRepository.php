<?php

namespace AnalyticsBundle\Repository;


class ClientAxRepository extends \Doctrine\ORM\EntityRepository
{
    public function myfindSitebyCodeAN($code)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT site 
    FROM AnalyticsBundle:ClientAx site
    WHERE 
    site.splissite = 1
    AND 
    site.accountnum LIKE :code
    '
        );

        $query->setParameters(array(
            'code' => $code,
        ));

        return $site = $query->setMaxResults(1)->getOneOrNullResult();
    }


    public function myfindSite($coderacco)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT site 
    FROM AnalyticsBundle:ClientAx client
    JOIN AnalyticsBundle:ClientAx site
    WHERE 
    site.splissite = 1
    AND 
    site.totalcodesraccowithpipe LIKE :coderacco
    AND 
    client.accountnum = site.invoiceaccount 
    '
        );

        $query->setParameters(array(
            'coderacco' => '%' . $coderacco . '%',
        ));

        return $sites = $query->getResult();
// to get just one result: $unseulclient = $query->setMaxResults(1)->getOneOrNullResult();
    }

    public function myfindClient($ia)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT client 
    FROM AnalyticsBundle:ClientAx client
    JOIN AnalyticsBundle:ClientAx site
    WHERE 
    site.splissite = 0
    AND 
    client.accountnum LIKE :ia
    '
        );

        $query->setParameters(array(
            'ia' => ''.$ia,
        ));

        return $client = $query->setMaxResults(1)->getOneOrNullResult();
    }




}
