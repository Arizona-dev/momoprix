<?php
namespace App\Controller\Auth;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Register extends AbstractController
{

    /**
     * @Route("/register", name="register")
     */
    public function register()
    {
        return $this->render('/register.html.twig');
    }

}