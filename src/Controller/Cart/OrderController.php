<?php
namespace App\Controller\Cart;

use App\Entity\Customer;
use App\Entity\Order;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

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
    public function orderIndex()
    {
        $user = $this->security->getUser();
        return $this->render('/checkout/checkout.html.twig', [
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal(),
            'user_id' => $user->getUsername()
        ]);
    }

    /**
     * @Route("/order/confirm", name="order_confirm")
     */
    public function orderConfirm(Request $request)
    {
        if ($this->isCsrfTokenValid('order_confirm' . $this->customer->getId(), $request->request->get('token'))) {
            $this->manager->remove($this->order);
            $this->manager->flush();
            $this->addFlash('success_delete', 'Adresse supprimée avec succès');
            
        }

        $this->cartService->setFullCart();

        return $this->render('/checkout/order_complete.html.twig', [
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal()
        ]);
    }

}