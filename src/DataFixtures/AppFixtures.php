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
            $product->setName('Produit '.$i);
            $product->setPrice(mt_rand(1, 20));
            $product->setBarCode(mt_rand(100000, 1000000));
            $product->setDateOfEntry(new DateTime('2020-03-29'));
            $product->setStock(100);
            $product->setCategoryIdcategory($categories[$i]->getId());
            $product->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vestibulum blandit ultricies. Nullam posuere posuere mi, ut auctor nulla. Fusce efficitur magna ac quam suscipit efficitur. Nunc magna nulla, accumsan eget fermentum eu, euismod vitae mauris. Nulla eget malesuada dolor.');
            $product->setImageUrl("https://fakeimg.pl/270x330/?text=Image&font=lobster");
            $manager->persist($product);
        }

        $manager->flush();
    }

    function generateCateg(ObjectManager $manager){
        
        $categ = [];
        for ($i = 0; $i < 50; $i++) {
            $category = new Category();
            $category->setName('Catégorie '.$i);
            $category->setImageUrl("https://fakeimg.pl/270x330/?text=Image&font=lobster");
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
            $category->setName('Sous-catégorie '.$i);
            $category->setImageUrl("https://fakeimg.pl/270x330/?text=Image&font=lobster");
            $category->addCategory($categories[$i]);
            $manager->persist($category);
            array_push($categories, $category);
        }
        $manager->flush();
        return $categories;

    }
}