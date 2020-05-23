<?php
namespace App\Controller\Cart;

use App\Entity\Orders;
use App\Entity\ProductHasOrder;
use App\Form\CheckoutType;
use App\Service\Cart\CartService;
use App\Repository\OrderRepository;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $securityContext = $this->container->get('security.authorization_checker');
        if($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {

            $user = $this->security->getUser();
            $priceHT = ($this->cartService->getTotal()) * 0.8;
            $priceTTC = $this->cartService->getTotal();
            $panier = $this->cartService->getFullCart();
            $checkout_form = $this->createForm(CheckoutType::class);
            $checkout_form->handleRequest($request);
            $addressExists = $this->addressRepository->findAllAddressById($user->getId());

            if($checkout_form->isSubmitted() && $panier != [])
            {
                $addressId = $checkout_form->getViewData()['delivery_address'];
                $address = $this->addressRepository->findOneAddressById($addressId);
                $order = new Orders();
                $order->setLabel('Commande de: ' . $user->getFirstname() . ' ' . $user->getLastname());
                $order->setStatus('00');
                /* STATUS 00 : En attente de préparation
                STATUS 01 : En cours de préparation
                STATUS 02 : En attente de livraison
                STATUS 03 : En cours de livraison
                STATUS 04 : Livrée
                STATUS 99 : Terminée
                */
                if($priceTTC < 60) {
                    $priceHT = $priceHT + (8*0.8);
                    $priceTTC = $priceTTC + 8; //add shipping fee
                }
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
        }
        return $this->render('/checkout/checkout.html.twig', [
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal(),
            'checkout_form' => $checkout_form->createView(),
            'address_exists' => $addressExists
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