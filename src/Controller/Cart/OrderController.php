<?php
namespace App\Controller\Cart;

use App\Entity\Orders;
use App\Entity\Address;
use App\Entity\ProductHasOrder;
use App\Form\CheckoutType;
use App\Service\Cart\CartService;
use App\Repository\OrderRepository;
use App\Repository\AddressRepository;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends AbstractController
{

    private $cartService;
    private $addressRepository;
    
    public function __construct(EntityManagerInterface $manager, OrderRepository $order, CartService $cartService, Security $security, AddressRepository $addressRepository)
    {
        $this->manager = $manager;
        $this->order = $order;
        $this->cartService = $cartService;
        $this->security = $security;
        $this->addressRepository = $addressRepository;
    }
    
    /**
     * @Route("/order", name="order_index")
     */
    public function orderIndex(Request $request)
    {
        $user = $this->security->getUser();
        $priceHT = ($this->cartService->getTotal()) * 0.8;
        $priceTTC = $this->cartService->getTotal();
        $panier = $this->cartService->getFullCart();
        $checkout_form = $this->createForm(CheckoutType::class);
        $checkout_form->handleRequest($request);
        if($checkout_form->isSubmitted())
        {
            $addressId = $checkout_form->getViewData()['delivery_address'];
            $address = $this->addressRepository->findOneAddressById($addressId);
            $order = new Orders();
            $order->setLabel('Commande de: ' . $user->getFirstname() . ' ' . $user->getLastname());
            $order->setStatus('En attente de préparation');
            $order->setPriceHT($priceHT);
            $order->setPriceTTC($priceTTC);
            $order->setAddressId($address[0]);
            $order->setCustomerId($user);
            $order->setDatePayment(new \DateTime());
            foreach($panier as &$item)
            {
                $productHasOrder = new ProductHasOrder();

                $productHasOrder->setOrder($order);
                $productHasOrder->setProduct($item['product'][0]);
                $productHasOrder->setQuantity($item['quantity']);

                $this->manager->persist($productHasOrder);
            }
            $this->manager->persist($order);
            $this->manager->flush();
            return $this->redirectToRoute('order_confirm');
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