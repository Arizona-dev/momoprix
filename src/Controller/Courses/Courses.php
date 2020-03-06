<?php
namespace App\Controller\Courses;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Courses extends AbstractController
{

    /**
     * @Route("/Courses", name="courses")
     */
    public function courses()
    {
        return $this->render('/product.html.twig');
    }

}