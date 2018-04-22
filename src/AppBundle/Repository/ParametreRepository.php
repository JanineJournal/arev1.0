<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ParametreRepository extends EntityRepository
{
    public function findAllTypesCentrales()
    {
        return $this->createQueryBuilder('p')
            ->select('p.valeur_libelle.value')
            ->where('p.categorie = :categorie')
            ->setParameter('categorie', "type centrale")
            ->getQuery()
            ->getResult();

    }

    public function findAllTypesClient()
    {
        return $this->createQueryBuilder('p')
            ->select('p.valeur_libelle.value')
            ->where('p.categorie = :categorie')
            ->setParameter('categorie', "type client")
            ->getQuery()
            ->getArrayResult();
    }
}
