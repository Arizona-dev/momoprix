<?php
namespace App\Controller\Customer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController {

    //Mon compte | modifier le profil
    /**
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        return $this->render('/customer/index.html.twig');
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