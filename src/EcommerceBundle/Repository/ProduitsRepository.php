<?php

namespace EcommerceBundle\Repository;

/**
 * ProduitsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitsRepository extends \Doctrine\ORM\EntityRepository
{
    public function findArray($array)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.id IN (:array)')
            ->setParameter('array', $array);
        return $qb->getQuery()->getResult();
    }

    public function byCategorie($categorie)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.categorie = :categorie')
            ->andWhere('u.disponible = 1')
            ->orderBy('u.id')
            ->setParameter('categorie', $categorie);
        return $qb->getQuery()->getResult();
    }

    public function Recherche($mots)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.nom like :mots')
            ->andWhere('u.disponible = 1')
            ->orderBy('u.id', 'ASC')
            ->setParameter('mots', $mots);

        return $qb->getQuery()->getResult();
    }
}
