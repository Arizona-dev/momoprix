<?php
namespace App\Controller\Customer;

use App\Repository\CustomerRepository;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController {

    private $repository;

    public function __construct(CustomerRepository $repository, Security $security)
    {
        $this->repository = $repository;
        $this->security = $security;
    }

    //Mon compte | modifier le profil
    /**
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        $user = $this->security->getUser();
        $email = $user->getEmail();

        return $this->render('/customer/index.html.twig', [
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'email' => $user->getEmail(),
            'number' => $user->getFirstname(),

        ]);
    }

    // Mes commandes
    /**
     * @Route("/profile/orders", name="profile_orders")
     */
    public function orders()
    {
        return $this->render('/customer/orders.html.twig');
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
     * @Route("/profile/address", name="profile_addresses")
     */
    public function addresses()
    {
        return $this->render('/customer/addresses.html.twig');
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