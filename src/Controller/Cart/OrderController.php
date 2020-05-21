<?php
namespace App\Controller\Cart;

use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    
    /**
     * @Route("/order", name="order_index")
     */
    public function orderIndex(CartService $cartService)
    {

        return $this->render('/checkout/checkout.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

}