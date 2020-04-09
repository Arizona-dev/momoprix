<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
    public function findAllVisible(): array
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT p.id, p.product_name, p.price, p.price_weight, p.image_url, p.description, p.specifications, c.category_name
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            WHERE stock > '0'
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays
        return $stmt->fetchAll();
    }

    /**
    * @return Product[] Returns a Product object
    */
    public function findProduct($id)
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
