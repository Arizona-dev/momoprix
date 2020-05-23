<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param CategoryRepository $repository
     * @return Response
     */
    public function index(CategoryRepository $repository, CartService $cartService): Response
    {
        $category = $repository->findAll();
        return $this->render('/index.html.twig', [
            'current_menu' => 'home',
            'categories' => $category,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

}