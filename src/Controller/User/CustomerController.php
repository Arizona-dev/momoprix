<?php
namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController {

    /**
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        return $this->render('/user/index.html.twig');
    }

}