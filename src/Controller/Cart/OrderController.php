<?php
namespace App\Controller\Cart;

use App\Entity\Order;
use App\Entity\Customer;
use App\Form\CheckoutType;
use App\Service\Cart\CartService;
use App\Repository\OrderRepository;
use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    protected $customer;
    protected $order;
    protected $cartService;
    protected $security;
    
    public function __construct(CustomerRepository $customer, OrderRepository $order, CartService $cartService, Security $security)
    {
        $this->customer = $customer;
        $this->order = $order;
        $this->cartService = $cartService;
        $this->security = $security;
    }
    
    /**
     * @Route("/order", name="order_index")
     */
    public function orderIndex(Request $request)
    {
        $checkout_form = $this->createForm(CheckoutType::class);
        $checkout_form->handleRequest($request);
        if($checkout_form->isSubmitted())
        {
            $this->manager->remove($this->order);
            $this->manager->flush();
            
        }

        return $this->render('/checkout/checkout.html.twig', [
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal(),
            'checkout_form' => $checkout_form->createView()
        ]);
    }

    /**
     * @Route("/order/confirm", name="order_confirm")
     */
    public function orderConfirm(Request $request)
    {
        $this->cartService->setFullCart();

        return $this->render('/checkout/order_complete.html.twig', [
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal()
        ]);
    }

}