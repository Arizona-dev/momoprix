<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use DateTime;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = $this->generateSubCateg($manager);

        // create 50 products! Bam!
        for ($i = 0; $i < 50; $i++) {
            shuffle($categories);
            $product = new Product();
            $product->setName('product '.$i);
            $product->setPrice(mt_rand(10, 100));
            $product->setBarCode(mt_rand(1000, 1000000));
            $product->setDateOfEntry(new DateTime('2020-03-06'));
            $product->setStock(100);
            $product->setCategoryIdcategory($categories[$i]->getId());
            $product->setDescription('Ergonomic and stylish!');
            $product->setImageUrl("https://google.fr");
            $manager->persist($product);
        }

        $manager->flush();
    }

    function generateCateg(ObjectManager $manager){
        
        $categ = [];
        for ($i = 0; $i < 50; $i++) {
            $category = new Category();
            $category->setName('category '.$i);
            $category->setImageUrl("https://google.fr");
            $manager->persist($category);
            array_push($categ, $category);
        }
        $manager->flush();
        return $categ;
    }

    function generateSubCateg(ObjectManager $manager){
        
        $categories = $this->generateCateg($manager);
        for ($i = 0; $i < 25; $i++) {
            shuffle($categories);
            $category = new Category();
            $category->setName('subCategory '.$i);
            $category->setImageUrl("https://google.fr");
            $category->addCategory($categories[$i]);
            $manager->persist($category);
            array_push($categories, $category);
        }
        $manager->flush();
        return $categories;

    }
}