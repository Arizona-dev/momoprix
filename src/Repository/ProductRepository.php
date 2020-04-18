<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
    * @return Product[] Returns an array of Product objects
    */
    public function findAll(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->addSelect('c')
            ->leftJoin('p.Category','c')
            ->getQuery()
            ->getResult();
    }

    /**
    * @return Query
    */
    public function findAllQuery(ProductSearch $search): Query
    {
        $query = $this->createQueryBuilder('p');

        if($search->getMaxPrice()) {
            $query = $query
            ->andWhere('p.price < :maxprice')
            ->setParameter('maxprice', $search->getMaxPrice());
        }

        if($search->getMinPrice()) {
            $query = $query
            ->andWhere('p.price > :minprice')
            ->setParameter('minprice', $search->getMinPrice());
        }

        return $query->getQuery();
    }

    /**
    * @return Product[] Returns a Product object
    */
    public function findProductById($id)
    {
        return $this->createQueryBuilder('p')
            ->setParameter('p_id', $id)
            ->where('p.id = :p_id')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }








    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
