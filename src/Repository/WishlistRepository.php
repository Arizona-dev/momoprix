<?php

namespace App\Repository;

use App\Entity\Wishlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wishlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wishlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wishlist[]    findAll()
 * @method Wishlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishlistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wishlist::class);
    }

    /**
     * @return Wishlist[] Returns an array of Wishlist objects
     */
    public function getWishlistById($value)
    {
        return $this->createQueryBuilder('w')
            ->addSelect('c')
            ->addSelect('p')
            ->join('w.Product', 'c')
            ->join('c.wishlists','p')
            ->andWhere('p.Customer = :id')
            ->setParameter('id', $value)
            ->setMaxResults(25)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Wishlist[] Returns an array of Wishlist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
}
