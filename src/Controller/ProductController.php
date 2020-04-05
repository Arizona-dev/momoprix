<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @Route("/produits", name="index")
     */
    public function index(): Response
    {
        $product = $this->repository->findAllVisible();
        dump($product);
        return $this->render('/products.html.twig', [
            'current_menu' => 'products'
        ]);
    }
}