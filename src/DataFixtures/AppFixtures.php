<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use DateTime;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 50 products! Bam!
        for ($i = 0; $i < 50; $i++) {
            $category = new Category();
            $category->setName('category '.$i);
            $category->setImageUrl("https://google.fr");
            $manager->persist($category);
            $product = new Product();
            $product->setName('product '.$i);
            $product->setPrice(mt_rand(10, 100));
            $product->setBarCode(mt_rand(1000, 1000000));
            $product->setDateOfEntry(new DateTime('2020-03-06'));
            $product->setStock(100);
            $product->setCategoryIdcategory($i);
            $product->setDescription('Ergonomic and stylish!');
            $product->setImageUrl("https://google.fr");
            $manager->persist($product);
        }

        $manager->flush();
    }
}