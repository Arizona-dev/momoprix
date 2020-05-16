<?php
namespace App\Controller\Customer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController {

    /**
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        return $this->render('/customer/index.html.twig');
    }

}