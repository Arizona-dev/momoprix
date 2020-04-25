<?php
namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService)
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/panier/a/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService) 
    {
        $cartService->add($id);

        return $this->redirectToRoute('product.index');
    }

    /**
     * @Route("/panier/r/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService) 
    {
        $cartService->remove($id);

        return $this->redirectToRoute('cart_index');
    }

}