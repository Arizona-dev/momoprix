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
use Faker\Factory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $categories = $this->generateSubCateg($manager);

        // create 50 products! Bam!
        for ($i = 0; $i < 50; $i++) {
            shuffle($categories);
            $product = new Product();
            $product
            ->setName($faker->words(2, true))
            ->setPrice($faker->numberBetween(1, 30))
            ->setBarCode($faker->numberBetween(9800000, 9899999))
            ->setCreatedAt($faker->dateTimeAD('now', 'Europe/Paris'))
            ->setStock($faker->numberBetween(30, 200))
            ->setCategory($categories[$i])
            ->setDescription($faker->sentences(2, true))
            ->setSpecifications($faker->sentences(2, true))
            ->setImageUrl("Product.png");
            $manager->persist($product);
        }
        $manager->flush();
    }

    function generateCateg(ObjectManager $manager){
        
        $faker = Factory::create('fr_FR');
        $categ = [];
        for ($i = 0; $i < 50; $i++) {
            $category = new Category();
            $category
            ->setName($faker->words($nb = 1, $asText = true))
            ->setImageUrl("Product.png");
            $manager->persist($category);
            array_push($categ, $category);
        }
        $manager->flush();
        return $categ;
    }

    function generateSubCateg(ObjectManager $manager){
        
        $faker = Factory::create('fr_FR');
        $categories = $this->generateCateg($manager);
        for ($i = 0; $i < 25; $i++) {
            shuffle($categories);
            $category = new Category();
            $category->setName($faker->words($nb = 1, $asText = true));
            $category->setImageUrl("Product.png");
            $category->addCategoryHasCategory($categories[$i]);
            $manager->persist($category);
            array_push($categories, $category);
        }
        $manager->flush();
        return $categories;

    }
}