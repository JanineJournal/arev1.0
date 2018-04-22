<?php

namespace AnalyticsBundle\Repository;


use Doctrine\ORM\EntityRepository;

class DirpartyTableRepository extends EntityRepository
{
    public function myfindAllTech()
    {

        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT dirpar.name
    FROM AnalyticsBundle:EmplTable empl
    JOIN AnalyticsBundle:DirpartyTable dirpar
    WITH 
    empl.partyid = dirpar.partyid
    AND 
    empl.dataareaid = dirpar.dataareaid
    WHERE
    empl.dataareaid = :ctca
    AND 
    empl.calendarid LIKE :Technicien
    AND 
    empl.emplidentnumber LIKE :a
    '
        );

        $query->setParameters(array(
            'ctca' => 'ctca',
            'Technicien' => 'Technicien',
            'a'=> ''
        ));

        return $query->getArrayResult();
// to get just one result: $unseulclient = $query->setMaxResults(1)->getOneOrNullResult();

        /*SELECT NAME, CTC_TYPETECH
FROM   EMPLTABLE
       JOIN DIRPARTYTABLE
         ON DIRPARTYTABLE.DATAAREAID = EMPLTABLE.DATAAREAID
            AND EMPLTABLE.PARTYID = DIRPARTYTABLE.PARTYID
WHERE  EMPLTABLE.DATAAREAID = 'ctca'
       AND EMPLIDENTNUMBER = ''
       AND CALENDARID = 'Technicien'


        'SELECT NAME
    FROM AnalyticsBundle:EmplTable empl
    JOIN AnalyticsBundle:DirpartyTable dirpar
    WHERE
    empl.dataareaid = :ctca
    AND
    empl.calendarid LIKE :Technicien
    AND
    empl.emplidentnumber = :a
    '*/

// to get just one result: $unseulclient = $query->setMaxResults(1)->getOneOrNullResult();
    }




}
