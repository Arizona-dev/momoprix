<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param ProductRepository $repository
     * @return Response
     */
    public function index(ProductRepository $repository, CartService $cartService): Response
    {
        $products = $repository->findAll();

        return $this->render('/index.html.twig', [
            'current_menu' => 'home',
            'products' => $products,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

}