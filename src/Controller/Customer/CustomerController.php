<?php
namespace App\Controller\Customer;

use App\Entity\Address;
use App\Form\AddressType;
use App\Form\ProfileType;
use App\Service\Cart\CartService;
use App\Repository\OrderRepository;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * @var OrderRepository
     */
    protected $ordersRepository;

    /**
     * @var AddressRepository
     */
    protected $addressRepository;

    /**
     * @var CartService
     */
    protected $cartService;

    public function __construct(Security $security, EntityManagerInterface $manager, OrderRepository $ordersRepository, AddressRepository $addressRepository, CartService $cartService)
    {
        $this->security = $security;
        $this->manager = $manager;
        $this->ordersRepository = $ordersRepository;
        $this->addressRepository = $addressRepository;
        $this->cartService = $cartService;
    }

    //Mon compte | modifier le profil
    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->security->getUser();
        $user->setUpdatedAt(new \DateTime());
        
        $profile_form = $this->createForm(ProfileType::class, $user);
        $profile_form->handleRequest($request);

        if ($profile_form->isSubmitted()) 
        {
            $plainPassword = $profile_form->get('password')->getData();

            if ($plainPassword != null)  
            {
                if($profile_form->get('password')->getData() === $profile_form->get('confirmPassword')->getData()) 
                {
                    $hash = $encoder->encodePassword($user, $plainPassword);
                    $user->setPassword($hash);
                } else 
                {
                    $this->addFlash('danger', 'Les mots de passe ne correspondent pas!');
                    return $this->render('/customer/index.html.twig', [
                        'firstname' => $user->getFirstname(),
                        'lastname' => $user->getLastname(),
                        'email' => $user->getEmail(),
                        'number' => $user->getPhone(),
                        'profile_form' => $profile_form->createView(),
                        'items' => $this->cartService->getFullCart(),
                        'total' => $this->cartService->getTotal()
                    ]);
                }
            }
            
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('succes', 'Profil modifié avec succès!');
            return $this->render('/customer/index.html.twig', [
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'email' => $user->getEmail(),
                'number' => $user->getPhone(),
                'profile_form' => $profile_form->createView(),
                'items' => $this->cartService->getFullCart(),
                'total' => $this->cartService->getTotal()
            ]);
        }

        return $this->render('/customer/index.html.twig', [
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'email' => $user->getEmail(),
            'number' => $user->getPhone(),
            'profile_form' => $profile_form->createView(),
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal()
        ]);
    }

    // Mes commandes
    /**
     * @Route("/profile/orders", name="profile_orders")
     */
    public function orders()
    {
        $user = $this->security->getUser();
        $orders = $this->ordersRepository->findAllOrdersById($user->getId());
        dump($orders);
        return $this->render('/customer/orders.html.twig', [
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal(),
            'orders' => $orders
        ]);
    }

    // Mes factures
    /**
     * @Route("/profile/receipts", name="profile_receipts")
     */
    public function receipts()
    {
        return $this->render('/customer/receipts.html.twig');
    }

    //Mes adresses
    /**
     * @Route("/profile/address", name="add_address")
     */
    public function addAddress(Request $request)
    {
        $address = new Address();
        $user = $this->security->getUser();
        $address->setCustomerId($user);
        
        $getAddress = $this->addressRepository->findAllAddressById($user->getId());

        $address_form = $this->createForm(AddressType::class, $address);

        $address_form->handleRequest($request);
        
        if ($address_form->isSubmitted()) 
        {
            $this->manager->persist($address);
            $this->manager->flush();
            $this->addFlash('succes', 'Adresse ajouté avec succès!');
            return $this->render('/customer/addresses.html.twig', [
            'address_form' => $address_form->createView(),
            'address_list' => $getAddress,
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal()
            ]);
        }

        return $this->render('/customer/addresses.html.twig', [
            'address_form' => $address_form->createView(),
            'address_list' => $getAddress,
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal()
        ]);
    }

    /**
     * @Route("/profile/address/{id}", name="remove.address", methods="POST")
     */
    public function delete(Request $request, Address $address)
    {
        if ($this->isCsrfTokenValid('delete' . $address->getId(), $request->request->get('token'))) {
            $this->manager->remove($address);
            $this->manager->flush();
            $this->addFlash('success_delete', 'Adresse supprimée avec succès');
            
        }

        return $this->redirectToRoute('add_address');
    }

    //Moyens de paiements
    /**
     * @Route("/profile/payments", name="profile_payments")
     */
    public function payments()
    {
        return $this->render('/customer/payments.html.twig');
    }



}