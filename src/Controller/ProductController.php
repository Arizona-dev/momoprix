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
        $products = $this->repository->findAll();
        dump($products);
        return $this->render('/shop.html.twig', [
            'current_menu' => 'shop',
            'products' => $products
        ]);
    }

    /**
     * @Route("/courses-en-ligne/{slug}-{id}", name="product.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Product $product
     * @return Response
     */
    public function show(Product $product, string $slug, int $id): Response
    {
        if ($product->getSlug() !== $slug || $product->getId() !== $id) {
            return $this->redirectToRoute('product.show', [
                'id' => $product->getId(),
                'slug' => $product->getSlug()
            ], 301);
        }
        dump($product, $slug, $id);
        return $this->render('/product.html.twig', [
            'current_menu' => 'shop',
            'products' => $product
        ]);
    }

}