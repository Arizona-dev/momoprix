<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Entity\Product;
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
     * @Route("/courses-en-ligne", name="product.index")
     * @return Response
     */
    public function index(): Response
    {
        $products = $this->repository->findAllVisible();
        
        dump($products);
        return $this->render('/shop.html.twig', [
            'current_menu' => 'shop',
            'products' => $products
        ]);
    }

    /**
     * @Route("/courses-en-ligne/{slug}-{id}", name="product.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Product $products
     * @return Response
     */
    public function show(Product $products): Response
    {
        return $this->render('/product.html.twig', [
            'current_menu' => 'shop',
            'products' => $products
        ]);
    }

}