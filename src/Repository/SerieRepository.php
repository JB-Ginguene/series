<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findBestSeries()
    {

        //En DQL
        /*
        $entityManager = $this->getEntityManager();
        $dql = "SELECT s
                FROM App\Entity\Serie as s
                WHERE s.vote > 8
                AND s.popularity > 100
                ORDER BY s.popularity DESC";

        $query = $entityManager->createQuery($dql);
        */

        // Avec le queryBuilder
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder->andWhere('s.vote > 8')
            ->andWhere('s.popularity > 100')
            ->addOrderBy('s.popularity', 'DESC');
        $query = $queryBuilder->getQuery();

        // même chose pour les deux : que ce soit via queryBuilder ou DQL
        $query->setMaxResults(20);
        return $query->getResult();
    }
}
