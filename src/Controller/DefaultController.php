<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param ProductRepository $repository
     * @return Response
     */
    public function index(ProductRepository $repository): Response
    {
        $products = $repository->findAllVisible();
        dump($products);
        return $this->render('/index.html.twig', [
            'current_menu' => 'home',
            'products' => $products
        ]);
    }

}